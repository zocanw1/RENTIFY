<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','nis','kelas','email','role',
        'foto_profil','no_wa','password',
    ];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array {
        return ['email_verified_at'=>'datetime','password'=>'hashed'];
    }

    public function peminjaman()  { return $this->hasMany(Peminjaman::class); }
    public function activityLogs(){ return $this->hasMany(ActivityLog::class); }

    public function isAdmin(): bool     { return $this->role === 'admin'; }
    public function isSiswa(): bool     { return $this->role === 'siswa'; }
    public function isKetuaTjkt(): bool { return $this->role === 'ketua_tjkt'; }
    public function isKetuaSija(): bool { return $this->role === 'ketua_sija'; }
    public function isWaliKelas(): bool { return $this->role === 'wali_kelas'; }
    public function isStaff(): bool     { return in_array($this->role,['admin','ketua_tjkt','ketua_sija','wali_kelas']); }

    public function getJurusan(): ?string {
        if ($this->role === 'ketua_tjkt') return 'TJKT';
        if ($this->role === 'ketua_sija') return 'SIJA';
        return null;
    }

    public function fotoUrl(): string {
        return $this->foto_profil
            ? asset('storage/'.$this->foto_profil)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=4f46e5&color=fff&bold=true';
    }
}
