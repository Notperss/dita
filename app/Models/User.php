<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\MasterData\Company\Company;
use App\Models\ManagementAccess\DetailUser;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\MasterData\WorkUnits\Division;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use LogsActivity;

    /**
     * Get the options for the activity log.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'password', 'division_id', 'company_id']) // Specify the attributes you want to log
            ->logOnlyDirty() // Log only changed attributes
            ->useLogName('user'); // Specify the log name
    }

    /**
     * Get the description for the given event.
     *
     * @param  string  $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName) : string
    {
        return "User has been {$eventName}";
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'company_id',
        'division_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function detail_user()
    {
        // 2 parameter (path model, field foreign key)
        return $this->hasOne(DetailUser::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
