<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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


    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->where('status', 'accepted')
            ->withTimestamps();
    }


    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id')->where('status', 'pending');
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id')->where('status', 'pending');
    }

    // more relationships

    public function friendRequests()
    {
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id');
    }

    public function friendRequestsSent()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentLikes()
    {
        return $this->belongsToMany(Comment::class, 'comment_likes', 'user_id', 'comment_id');
    }

    public function commentReplies()
    {
        return $this->hasMany(CommentReply::class);
    }

    public function commentReplyLikes()
    {
        return $this->belongsToMany(CommentReply::class, 'comment_reply_likes', 'user_id', 'comment_reply_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function messageReplies()
    {
        return $this->hasMany(MessageReply::class);
    }

    public function messageReplyLikes()
    {
        return $this->belongsToMany(MessageReply::class, 'message_reply_likes', 'user_id', 'message_reply_id');
    }

    public function messageLikes()
    {
        return $this->belongsToMany(Message::class, 'message_likes', 'user_id', 'message_id');
    }

    public function messageRepliesSent()
    {
        return $this->belongsToMany(MessageReply::class, 'message_replies', 'user_id', 'message_reply_id');
    }

    public function messageRepliesReceived()
    {
        return $this->belongsToMany(MessageReply::class, 'message_replies', 'user_id', 'message_reply_id');
    }

    public function messageRepliesSentTo()
    {
        return $this->belongsToMany(MessageReply::class, 'message_replies', 'user_id', 'message_reply_id');
    }

    public function messageRepliesReceivedFrom()
    {
        return $this->belongsToMany(MessageReply::class, 'message_replies', 'user_id', 'message_reply_id');
    }

    public function messageRepliesSentToUser()
    {
        return $this->belongsToMany(MessageReply::class, 'message_replies', 'user_id', 'message_reply_id');
    }

    public function messageRepliesReceivedFromUser()
    {
        return $this->belongsToMany(MessageReply::class, 'message_replies', 'user_id', 'message_reply_id');
    }

    public function messageRepliesSentToUserFromUser()
    {
        return $this->belongsToMany(MessageReply::class, 'message_replies', 'user_id', 'message_reply_id');
    }

    public function messageRepliesReceivedFromUserToUser()
    {
        return $this->belongsToMany(MessageReply::class, 'message_replies', 'user_id', 'message_reply_id');
    }

    public function messageRepliesSentToUserFromUserToUser()
    {
        return $this->belongsToMany(MessageReply::class, 'message_replies', 'user_id', 'message_reply_id');
    }
}
