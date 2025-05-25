<?php

namespace App\Policies;

use App\Models\TransferenciaDocumental;
use App\Models\User;

class TransferenciaDocumentalPolicy
{
    /**
     * ¿Puede firmar “Entregado”?
     */
    public function entregar(User $user, TransferenciaDocumental $t)
    {
        // Solo admin/archivista y si está ELABORADO
        return in_array($user->role->nombre_rol, ['admin','archivista'])
            && $t->estado_flujo === 'ELABORADO';
    }

    /**
     * ¿Puede firmar “Recibido”?
     */
    public function recibir(User $user, TransferenciaDocumental $t)
    {
        // Solo admin/archivista y si está ENTREGADO
        return in_array($user->role->nombre_rol, ['admin','archivista'])
            && $t->estado_flujo === 'ENTREGADO';
    }

    /**
     * (Opcional) ¿Puede archivar al final?
     */
    public function archivar(User $user, TransferenciaDocumental $t)
    {
        // Solo quien la creó, y si ya está RECIBIDO
        return $user->id === $t->user_id
            && $t->estado_flujo === 'RECIBIDO';
    }
}
