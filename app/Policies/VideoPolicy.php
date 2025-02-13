<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;

class VideoPolicy
{
    /**
     * Determina si l'usuari pot editar el vídeo.
     */
    public function edit(User $user, Video $video)
    {

        return $user->id === $video->user_id; // Només el creador del vídeo pot editar-lo


    }

    /**
     * Determina si l'usuari pot eliminar el vídeo.
     */
    public function delete(User $user, Video $video)
    {
        return $user->id === $video->user_id || $user->hasRole('video_manager'); // Els video_manager també poden eliminar vídeos
    }

    public function update(User $user, Video $video)
    {
        // Suposant que un vídeo només pot ser editat pel creador o un administrador
        return $user->id === $video->user_id || $user->hasRole('admin');
    }
}
