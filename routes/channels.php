<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId || $user->role === 'admin';
});

Broadcast::channel('admin.chat', function ($user) {
    return $user->role === 'admin';
});
