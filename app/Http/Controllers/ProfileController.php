<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use ProtoneMedia\Splade\Facades\Toast;
use App\Models\User;
use App\Models\Documentos;
use Illuminate\Support\Facades\Log;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        
        $ret = $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $ret->save();

        Toast::title(__('Profile updated!'))->autoDismiss(5);

        return Redirect::route('profile.edit');
    }


    /**
     * Update the user's profile ZIP password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatezip(Request $request, $id)
    {

        $this->validate($request, [
            'keyword' => 'required|max:254',
        ]);
        
        $user = User::findorfail($id);

        $input = $request->all();
 
        $user->fill($input);

        $user->save();

        Toast::title(__('Profile updated!'))->autoDismiss(5);

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        $docs = Documentos::where('user_id', '=', $user->id)->get();

        foreach($docs as $elem) {
            if ($elem->nomearq != '') {
                $created = date('Y', strtotime($elem->created_at));
                $file = public_path('uploads/' . $user->id . '/' . $created . '/' . $elem->nomearq);
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        Toast::title(__('Account deleted!'))->autoDismiss(5);

        return Redirect::to('/');
    }
}
