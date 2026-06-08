<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SqlSnapshotSeeder extends Seeder
{
    public function run(): void
    {
        $dumpPath = base_path('dbd_peminjaman_alat.sql');

        if (!File::exists($dumpPath)) {
            return;
        }

        $sql = File::get($dumpPath);

        foreach (['settings', 'users'] as $table) {
            $statements = $this->extractInsertStatements($sql, $table);

            if ($statements === []) {
                continue;
            }

            DB::table($table)->delete();

            foreach ($statements as $statement) {
                $payload = $this->parseInsertStatement($statement);

                foreach (array_chunk($payload['rows'], 100) as $chunk) {
                    DB::table($table)->insert($chunk);
                }
            }
        }
    }

    /**
     * @return array<int, string>
     */
    protected function extractInsertStatements(string $sql, string $table): array
    {
        $pattern = sprintf('/INSERT INTO `%s` .*?;/s', preg_quote($table, '/'));
        preg_match_all($pattern, $sql, $matches);

        return $matches[0] ?? [];
    }

    /**
     * @return array{columns: array<int, string>, rows: array<int, array<string, mixed>>}
     */
    protected function parseInsertStatement(string $statement): array
    {
        preg_match('/INSERT INTO `[^`]+` \((?<columns>.*?)\) VALUES\s*(?<values>.*);/s', $statement, $matches);

        $columns = array_map(
            static fn (string $column): string => trim($column, " `\r\n\t"),
            explode(',', $matches['columns'])
        );

        $rows = [];
        $currentRow = [];
        $currentValue = '';
        $inString = false;
        $escape = false;
        $depth = 0;

        foreach (str_split($matches['values']) as $character) {
            if ($depth === 0) {
                if ($character === '(') {
                    $depth = 1;
                    $currentRow = [];
                    $currentValue = '';
                }

                continue;
            }

            if ($inString) {
                $currentValue .= $character;

                if ($escape) {
                    $escape = false;
                    continue;
                }

                if ($character === '\\') {
                    $escape = true;
                    continue;
                }

                if ($character === "'") {
                    $inString = false;
                }

                continue;
            }

            if ($character === "'") {
                $inString = true;
                $currentValue .= $character;
                continue;
            }

            if ($character === ',') {
                $currentRow[] = $this->normalizeValue($currentValue);
                $currentValue = '';
                continue;
            }

            if ($character === ')') {
                $currentRow[] = $this->normalizeValue($currentValue);
                $rows[] = array_combine($columns, $currentRow);
                $currentValue = '';
                $currentRow = [];
                $depth = 0;
                continue;
            }

            $currentValue .= $character;
        }

        return [
            'columns' => $columns,
            'rows' => $rows,
        ];
    }

    protected function normalizeValue(string $value): mixed
    {
        $value = trim($value);

        if (strtoupper($value) === 'NULL') {
            return null;
        }

        if ($value !== '' && $value[0] === "'" && substr($value, -1) === "'") {
            $value = substr($value, 1, -1);

            return str_replace(
                ["\\\\", "\\'", '\\"', '\r', '\n'],
                ['\\', "'", '"', "\r", "\n"],
                $value
            );
        }

        if (is_numeric($value)) {
            return str_contains($value, '.') ? (float) $value : (int) $value;
        }

        return $value;
    }
}
