<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Lấy danh sách những quyền thông qua role
     *  dựa trên user đang đăng nhập
     * @return array
     */
    public function postPermission()
    {
        $user = Auth::user();
        $data['permission'][config('app.modules.posts')] = [];
        foreach ($user->role->permissions as $v) {
            if ($v->group_permission_id == config('app.group_permission_id.post')) {
                $data['permission'][config('app.modules.posts')][] = $v->name;
            }
        }
        return $data;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $data = $this->postPermission();
        if (empty($data)) {
            return false;
        }

        $check = isRole($data['permission'], config('app.modules.posts'), 'viewAny');
        if ($check) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Post $post)
    {
        $data = $this->postPermission();
        if (empty($data)) {
            return false;
        }

        $check = isRole($data['permission'], config('app.modules.posts'), 'view');
        if ($check && $user->id === $post->user_id) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $data = $this->postPermission();
        if (empty($data)) {
            return false;
        }

        $check = isRole($data['permission'], config('app.modules.posts'), 'create');
        if ($check) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Post $post)
    {
        $data = $this->postPermission();
        if (empty($data)) {
            return false;
        }

        $check = isRole($data['permission'], config('app.modules.posts'), 'update');;
        if ($check && $user->id === $post->user_id) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Post $post)
    {
        $data = $this->postPermission();
        if (empty($data)) {
            return false;
        }

        $check = isRole($data['permission'], config('app.modules.posts'), 'delete');
        if ($check && $user->id === $post->user_id) {
            return true;
        }
    }
}
