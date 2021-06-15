<?php

namespace Modules\Users\Http\Controllers;

use DB, File, Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Users\Entities\Role;
use Modules\Users\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Users\Entities\AccountSetting;
use Modules\Users\Entities\CoverPhotoUploader;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UsersController extends Controller
{

    public function dashboard()
    {
        return view('users::dashboard.index');
    }

    public function adminsettings()
    {
        return view('users::settings.adminsettings');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $bladeTemplate = $request->ajax() ? 'users::partials.index' : 'users::index';

        $q         = $request->input('q');
        $status    = $request->input('status');
        $isTrashed = $request->input('is_trashed');
        $role      = $request->input('role');
        $limit     = $request->input('limit') ? $request->input('limit') : 25;
        $sort      = $request->input('sort') ? $request->input('sort') : 'id';
        $order     = $request->input('order') ? $request->input('order') : 'desc';

        // Data for view
        $is_trashed = $isTrashed;

        // work around for status
        $statusOrder = ($order == 'asc') ? 'desc' : 'asc';

        $users = User::
            select('users.*', 'users.permission as status', 'roles.name as role', 'roles.key as roleKey')
            ->leftJoin('roles', 'roles.permission', '=', 'users.permission');

        $users = ($sort == 'status')
                ? $users->orderBy($sort, $statusOrder)
                : $users->orderBy($sort, $order);

        // check if user is deleted
        $users = $isTrashed ? $users->where('is_trashed', 1) : $users->where('is_trashed', 0);

        // if search query is not null
        if ($q != null) {
            $users = $users->where('users.name', 'LIKE', '%' . $q . '%')
                ->orWhere ( 'users.username', 'LIKE', '%' . $q . '%' )
                ->orWhere ( 'users.email', 'LIKE', '%' . $q . '%' );
        }

        // if status is suspended
        if ($status === 'suspended') {
            $users = $users->where('users.permission', '<', 1);
        }else{
            $users = $users->where('users.permission', '>', 0);
        }

        // if role is set
        if ($role) {
            $users = $users->where('roles.key', $role);
        }


        $users = $users->paginate($limit);

        $availableLimit = ['25', '50', '100', '150', '200'];

        // counters
        $allUsersCount       = User::where([
            ['is_trashed', '=', 0],
            ['permission', '>', 0]
        ])->count();

        $suspendedUsersCount = User::where([
            ['permission', '<', 1],
            ['is_trashed', '=', 0],
        ])->count();

        $trashedUsersCount   = User::where('is_trashed', '=', 1)->count();

        $registeredPermission = Role::where('key', 'registered')->first()->permission;
        $editorPermission     = Role::where('key', 'editor')->first()->permission;
        $adminPermission      = Role::where('key', 'admin')->first()->permission;

        $registeredUsersCount  = User::where([
            ['permission', '=', $registeredPermission],
            ['is_trashed', '=', 0],
        ])->count();

        $editorUsersCount     = User::where([
            ['permission', '=', $editorPermission],
            ['is_trashed', '=', 0],
        ])->count();

        $adminUsersCount      = User::where([
            ['permission', '=', $adminPermission],
            ['is_trashed', '=', 0],
        ])->count();

        return view($bladeTemplate,
            compact('users', 'q', 'limit', 'availableLimit', 'sort', 'order', 'allUsersCount', 'suspendedUsersCount', 'trashedUsersCount', 'registeredUsersCount', 'editorUsersCount', 'adminUsersCount', 'is_trashed', 'status', 'role', 'request')
        );

        // return view('users::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $roles = DB::table('roles')->orderBy('id', 'desc')->get();
        return view('components.users.add-user-form', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // validate data
        $this->validate($request,[
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        // get inputs
        $name            = $request->input('name');
        $email           = $request->input('email');
        $username        = $request->input('username');
        $password        = $request->input('password');
        $bio = $request->input('bio');
        $twitter_link = $request->input('twitter_link');
        $facebook_link = $request->input('facebook_link');
        $instagram_link = $request->input('instagram_link');
        $selectedRoleKey = $request->input('role');

        // save updated user
        $user = new User;
        $user->name     = $name;
        $user->email    = $email;
        $user->username = $username;
        $user->password = Hash::make($password);

        $selectedRole = Role::where('key', $selectedRoleKey)->first();
        $permission   = $selectedRole->permission;

        $user->permission = $permission;

        $saved = $user->save();

        AccountSetting::create([
            'user_id' => $user->id,
            'bio' => $bio,
            'twitter_link' => $twitter_link,
            'facebook_link' => $facebook_link,
            'instagram_link' => $instagram_link
        ]);

        $response = [
            'status'  => 'success',
            'message' => 'User has been created.',
            'clear'   => true,
        ];

        if (!$saved) {
            $response = [
                'status'  => 'error',
                'message' => 'Failed to add user. Please try again.',
            ];
        }

        return response()->json($response);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('account_setting')->find($id);
        $roles = DB::table('roles')->orderBy('id', 'desc')->get();

        if (!$user) {
            return redirect('admin/users')->with('responseMessage', 'User not found.');
        }

        return view('components.users.edit-user-form', compact('user', 'roles'))->withoutShortcodes();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $responseMessage = 'User has been updated.';
        $user = User::find($id);

        if (!$user) {
            return redirect('admin/users')->with('responseMessage', 'User not found.');
        }

        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$id]
        ];

        if($request->has('avatar')) {
            $rules['avatar'] = ['image'];
        }

        // validate data
        $this->validate($request, $rules);

        // get inputs
        $name = $request->input('name');
        $email = $request->input('email');
        $username = $request->input('username');
        $bio = $request->input('bio');
        $twitter_link = $request->input('twitter_link');
        $facebook_link = $request->input('facebook_link');
        $instagram_link = $request->input('instagram_link');
        $selectedRoleKey = $request->input('role');

        // save updated user
        $user->name = $name;
        $user->email = $email;
        $user->username = $username;

        // do not update role for currently logged in admin
        if (auth()->user()->id != $id) {
            // get role key
            $selectedRole     = Role::where('key', $selectedRoleKey)->first();
            $permission       = $selectedRole->permission;

            // if user is currently suspended
            if ($user->permission == 0) {
                // then just update the previous permission
                $user->previous_permission = $permission;
            }else{
                // update the current permission
                $user->permission = $permission;
            }
        }

        $saved = $user->save();

        // AVATAR SECTION
        $lastUsedAvatar = $user->getMedia('avatars')->last();

        if ($request->file('avatar') !== null) {

            // check if there is currently set and then delete
            if ($lastUsedAvatar) {
                $lastUsedAvatar->delete();
            }

            // set avatar
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');

            // Copy avatar to specific folder
            $new_avatar = $user->copyAvatar();

            // Delete old avatar if not null
            if(!is_null($user->avatar)){
                $user_old_avatar = $user->avatar;
                $old_avatar_path = storage_path() . '/app/public/users-images/avatars/' . $user_old_avatar;
                if(File::exists($old_avatar_path)){
                    unlink($old_avatar_path);
                }
            }

            // Update in users table
            $user->update(['avatar' => $new_avatar]);

            // Delete user avatar from the media table, and file system
            $user->deleteMediaAvatar();
        }

        $response = [
            'status'  => 'success',
            'message' => 'User has been updated.',
        ];

        if (!$saved) {
            // $responseMessage = 'Failed to save details. Please try again.';
            $response = [
                'status'  => 'error',
                'message' => 'Failed to save details. Please try again.',
            ];
        }

        // Update or create account setting if user have no account settings yet
        if($user->account_setting){
            $user->account_setting->update([
                'bio' => $bio,
                'twitter_link' => $twitter_link,
                'facebook_link' => $facebook_link,
                'instagram_link' => $instagram_link
            ]);
        } else {
            AccountSetting::create([
                'user_id' => $user->id,
                'bio' => $bio,
                'twitter_link' => $twitter_link,
                'facebook_link' => $facebook_link,
                'instagram_link' => $instagram_link
            ]);
        }

        return response()->json($response);
        // return back()->with('responseMessage', $responseMessage);
    }

    public function getUpdateCoverPhoto($id)
    {
        $user = User::find($id);

        if(!$user) {
            return response()->json(['User does not exists.']);
        }

        if(!$user->account_setting){
            $account_setting = AccountSetting::create([
                'user_id' => $user->id
            ]);
        }

        $user->refresh();

        return view('users::settings-admin', compact('user'));
    }

    public function postAjaxUpdateCoverPhotoAdmin($id)
    {
        $this->validate(request(), ['base64Image' => 'required']);

        $user = User::find($id);

        if(!$user) {
            return response()->json(['User does not exists.']);
        }

        // Get and set old cover photo
        if($user->hasCoverPhoto()){
            $old_cover_photo = storage_path() . '/app/public/users-images/cover/' . $user->cover_photo;

            if(File::exists($old_cover_photo)){
                unlink($old_cover_photo);
            }
        }

        $cover_photo = (new CoverPhotoUploader)->uploadBase64Photo(request('base64Image'), 'storage/app/public/users-images/cover');

        $user->update([
            'cover_photo' => $cover_photo->file_name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cover photo has been updated!'
        ]);
    }

    /**
     * Activate user account
     * Set `permission` to `previous_permission`
     * Set `previous_permission` to `permission`
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $user = User::find($id);
        $responseMessage = 'Something went wrong. Please try again.';

        // if user not found
        if (!$user) {
            return redirect('admin/users')->with('responseMessage', 'User not found.');
        }

        // if user trying to activate is currently logged in admin
        if ($user->id == auth()->user()->id) {
            $responseMessage = 'You cannot change the status of your account.';
        }else{
            // if user account was already activated
            if ($user->permission > 0) {
                $responseMessage = 'User '. $user->email. ' was previously activated.';
            }else{
                $previousPermission = $user->permission;
                $newPermission = $user->previous_permission;

                $user->previous_permission = $previousPermission;
                $user->permission          = $newPermission;
                $saved                     = $user->save();

                if ($saved) {
                    $responseMessage = 'User account for '. $user->email. ' has been activated.';
                }else{
                    $responseMessage = 'Failed to activate the account of '. $user->email. '. Please try again.';
                }
            }

        }

        return redirect('admin/users')->with('responseMessage', $responseMessage);
    }

    /**
     * Suspend user account
     * Set `permission` to 0
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function suspend($id)
    {
        $user = User::find($id);
        $responseMessage = 'Something went wrong. Please try again.';

        // if user not found
        if (!$user) {
            return redirect('admin/users')->with('responseMessage', 'User not found.');
        }

        // if user trying to suspend is currently logged in admin
        if ($user->id == auth()->user()->id) {
            $responseMessage = 'You cannot suspend your logged in account.';
        }else{
            // if user account was already suspended
            if ($user->permission == 0) {
                $responseMessage = 'User '. $user->email. ' was previously suspended.';
            }else{
                $previousPermission = $user->permission;
                $newPermission = 0;

                $user->previous_permission = $previousPermission;
                $user->permission          = $newPermission;
                $saved                     = $user->save();

                if ($saved) {
                    $responseMessage = 'User account for '. $user->email. ' has been suspended.';
                }else{
                    $responseMessage = 'Failed to suspend the account of '. $user->email. '. Please try again.';
                }
            }

        }

        return redirect('admin/users')->with('responseMessage', $responseMessage);
    }

    /**
     * Update is_trashed to 1 from storage.
     * @param int $id
     * @return Response
     */
    public function trash($id)
    {
        $user = User::find($id);
        $responseMessage = 'Something went wrong. Please try again.';

        // if user not found
        if (!$user) {
            return redirect('admin/users')->with('responseMessage', 'User not found.');
        }

        // if user trying to delete is currently logged in admin
        if ($user->id == auth()->user()->id) {
            $responseMessage = 'You cannot delete your logged in account.';
        }else{

            $email            = $user->email;
            $user->is_trashed = 1;

            $deleted = $user->save();

            if ($deleted) {
                $responseMessage = 'User account of '. $email . ' has been deleted.';
            }else{
                $responseMessage = 'Failed to delete user '. $email . '. Please try again.';
            }

        }

        return redirect('admin/users')->with('responseMessage', $responseMessage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $responseMessage = 'Something went wrong. Please try again.';

        // if user not found
        if (!$user) {
            return redirect('admin/users')->with('responseMessage', 'User not found.');
        }

        // if user trying to delete is currently logged in admin
        if ($user->id == auth()->user()->id) {
            $responseMessage = 'You cannot permanently delete your logged in account.';
        }else{
            $email = $user->email;

            $deleted = $user->delete();

            if ($deleted) {
                $responseMessage = 'User account of '. $email . ' has been permanently deleted.';
            }else{
                $responseMessage = 'Failed to permanently delete user '. $email . '. Please try again.';
            }

        }

        return redirect('admin/users')->with('responseMessage', $responseMessage);
    }

    /**
     * Empty trash
     *
     * @return \Illuminate\Http\Response
     */
    public function emptyTrash()
    {
        $users = User::where('is_trashed', 1);

        $deleted = $users->delete();

        $responseMessage = 'Trash has been empty.';

        return redirect('admin/users')->with('responseMessage', $responseMessage);
    }

    public function bulkSuspend(Request $request)
    {
        $selectedIDs = $request->input('selectedIDs');
        $loggedInUser = auth()->user();
        $responseMessage = '';

        // if nothing is selected just return
        if ($selectedIDs == null) {
            return back();
        }

        foreach ($selectedIDs as $key => $id) {
            $user = User::find($id);

            if ($user) {
                if ($user->id == $loggedInUser->id) {
                    $responseMessage .= 'You cannot suspend currently logged in account.';
                    $responseMessage .= '</br>';
                }else{
                    // if user was already suspended then just do nothing
                    if ($user->permission == 0) {
                        $responseMessage .= 'User ' . $user->email . ' account was previously suspended.';
                        $responseMessage .= '</br>';
                    }else{
                        $user->previous_permission = $user->permission;
                        $user->permission          = 0;

                        $saved = $user->save();

                        if ($saved) {
                            $responseMessage .= 'User ' . $user->email . ' account has been suspended.';
                            $responseMessage .= '</br>';
                        }else{
                            $responseMessage .= 'Failed to suspend user account ' . $user->email . '. Please try again.';
                            $responseMessage .= '</br>';
                        }
                    }

                }

            }else{
                $responseMessage .= 'User with ID: '. $id . 'is not found.';
                $responseMessage .= '</br>';
            }
        }

        return back()->with('responseMessage', $responseMessage);

    }

    public function bulkDelete(Request $request)
    {
        $selectedIDs = $request->input('selectedIDs');
        $loggedInUser = auth()->user();
        $responseMessage = '';

        // if nothing is selected just return
        if ($selectedIDs == null) {
            return back();
        }

        foreach ($selectedIDs as $key => $id) {
            $user = User::find($id);

            if ($user) {
                if ($user->id == $loggedInUser->id) {
                    $responseMessage .= 'You cannot delete currently logged in account.';
                    $responseMessage .= '</br>';
                }else{
                    $user->is_trashed = 1;
                    $user->save();

                    $responseMessage .= 'User ' . $user->email . ' has been deleted.';
                    $responseMessage .= '</br>';
                }

            }else{
                $responseMessage .= 'User with ID: '. $id . 'is not found.';
                $responseMessage .= '</br>';
            }
        }

        return back()->with('responseMessage', $responseMessage);

    }

    public function settings()
    {
        $user = Auth::user();

        if(!$user->account_setting){
            $account_setting = AccountSetting::create([
                'user_id' => $user->id
            ]);
        }

        $user->refresh();

        return view('users::settings', compact('user'))->withoutShortcodes();
    }

    public function saveSettings(Request $request)
    {
        $alert = [
            'message' => 'Your settings have been saved.',
            'class'   => '',
        ];

        $validator = Validator::make($request->all(), [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'bio' => ['max:191'],
            'twitter_link' => ['max:191'],
            'facebook_link' => ['max:191'],
            'instagram_link' => ['max:191']
        ]);

        if ($validator->fails()) {
            $errors = '';

            foreach ($validator->messages()->getMessages() as $fieldName => $messages) {
                foreach ($messages as $message) {
                    $errors .= '<p>'.$message.'</p>';
                }
            }

            $alert = [
                'message' => $errors,
                'class'   => 'alert--error',
            ];

            return redirect()->back()->with('alert', $alert);
        }

        $user           = Auth::user();
        $user->name     = $request->input('name');
        $user->email    = $request->input('email');
        $user->password = $request->input('password') ? Hash::make($request->input('password')) : $user->password;


        $user->account_setting->update([
            'bio' => request('bio') ? request('bio') : $user->account_setting->bio,
            'twitter_link' => request('twitter_link'),
            'facebook_link' => request('facebook_link'),
            'instagram_link' => request('instagram_link')
        ]);


        // get last used avatar
        $lastUsedAvatar = Auth::user()->getMedia('avatars')->last();

        // if user want to delete currently used avatar
        if ($request->input('delete_avatar')) {
            $lastUsedAvatar->delete();
        }

        // if user uploads avatar
        if ($request->file('avatar') !== null) {

            // check if there is currently set and then delete
            if ($lastUsedAvatar) {
                $lastUsedAvatar->delete();
            }

            // set avatar
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');

            // Copy avatar to specific folder
            $new_avatar = auth()->user()->copyAvatar();

            // Delete old avatar if not null
            if(!is_null(auth()->user()->avatar)){
                $user_old_avatar = auth()->user()->avatar;
                $old_avatar_path = storage_path() . '/app/public/users-images/avatars/' . $user_old_avatar;
                if(File::exists($old_avatar_path)){
                    unlink($old_avatar_path);
                }
            }

            // Update in users table
            auth()->user()->update(['avatar' => $new_avatar]);

            // Delete user avatar from the media table, and file system
            auth()->user()->deleteMediaAvatar();
        }

        if (!$user->save()) {
            $alert = [
                'message' => 'Failed to save. Please try again.',
                'class'   => 'alert--error',
            ];

            return back()->with('alert', $alert);
        }

        return back()->with('alert', $alert);
    }

    public function postAjaxUpdateCoverPhoto()
    {
        $this->validate(request(), ['base64Image' => 'required']);

        $user = auth()->user();

        // Get and set old cover photo
        if($user->hasCoverPhoto()){
            $old_cover_photo = storage_path() . '/app/public/users-images/cover/' . $user->cover_photo;

            if(File::exists($old_cover_photo)){
                unlink($old_cover_photo);
            }
        }

        $cover_photo = (new CoverPhotoUploader)->uploadBase64Photo(request('base64Image'), 'storage/app/public/users-images/cover');

        $user->update([
            'cover_photo' => $cover_photo->file_name
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cover photo has been updated!'
        ]);
    }

    public function postAjaxDeleteAvatar()
    {
        $user = auth()->user();

        if(!$user->avatar){
            return response()->json([
                'status' => true,
                'redirect_url' => url('users/settings')
            ]);
        }

        // Delete all avatars associated with this user
        $user->deleteAvatarFile();
        $user->update(['avatar' => NULL]);

        return response()->json([
            'status' => true,
            'message' => 'Avatar has been deleted!',
            'redirect_url' => url('users/settings')
        ]);
    }

    public function postAjaxDeleteCoverPhoto()
    {
        $user = auth()->user();

        if($user->hasCoverPhoto()){
            $old_cover_photo = storage_path() . '/app/public/users-images/cover/' . $user->cover_photo;

            if(File::exists($old_cover_photo)){
                unlink($old_cover_photo);
            }

            $user->update(['cover_photo' => NULL]);
        }


        return response()->json([
            'status' => true,
            'message' => 'Cover photo has been deleted!',
            'redirect_url' => url('users/settings')
        ]);
    }

    public function getProfile($username = null)
    {
        $user = ($username) ? User::where('username', $username)->first()
                : auth()->user();

        if (!$user) {
            abort(403);
        }

        $posts = $user->posts()->where('is_published', true)->latest()->get();

        $data['user']  = $user;
        $data['posts'] = $posts;

        return view('templates.profile.default', $data);
    }
}
