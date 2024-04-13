<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'surname',
        'gender',
        'dob',
        'bio',
        'email',
        'location',
        'interests',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $user->assignRole('pending verification');
        });
    }

    public function hasPhotos()
    {
        return $this->photos();
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function like(User $likedUser, bool $isLike = true)
    {
        $this->likes()->create([
            'liked_user_id' => $likedUser->id,
            'is_like' => $isLike,
        ]);
    }

    public function dislike(User $dislikedUser)
    {
        return $this->like($dislikedUser, false);
    }

    public function matchings(): BelongsToMany
    {
        return $this->belongsToMany(Matching::class, 'matchings', 'user1_id', 'user2_id')
        ->where('user1_id', $this->id)
        ->orWhere('user2_id', $this->id);
    }

    public function chatRooms(): BelongsToMany
    {
        return $this->belongsToMany(ChatRoom::class);
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function otherUserNotifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'other_user_id');
    }

    public function reportSuspect(): HasMany
    {
        return $this->hasMany(Report::class, 'suspect');
    }

    public function reportComplainant(): HasMany
    {
        return $this->hasMany(Report::class, 'complainant');
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class, 'user');
    }

    public function supportTicketsChatRoom(): HasMany
    {
        return $this->hasMany(SupportTicketChatRoom::class, 'user');
    }

    public function supportChatRoomMessage(): HasMany
    {
        return $this->hasMany(SupportTicketChatRoomMessages::class, 'user');
    }

    public function identity() : HasOne
    {
        return $this->hasOne(Identity::class, 'user');
    }
}
