<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;


// routes/channels.php
// Broadcast::channel('messages.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// Broadcast::channel('typing.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });


Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});