import { usePage } from '@inertiajs/vue3';

export function usePermissions()
{
    const hasRole = (name) => usePage().props.auth.role.includes(name);
    const hasPerm = (permission) =>  usePage().props.auth.perms.some(perm => perm.name === permission);

    return { hasRole, hasPerm }
}
