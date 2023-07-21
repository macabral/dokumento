<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <img src="assets/dokumento.png" width="84" alt="logo Dokumento!">
        </div>

        <div class="flex mt-3 justify-center text-xl font-semibold">
            {{ __('Personal Document Management') }}
        </div>

        @if (Route::has('login'))
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-8">
                @auth
                    <Link href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500">{{ __('Dashboard') }}</Link>
                @else
                    <Link href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500">Log in</Link>

                    @if (Route::has('register'))
                        <Link href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500">{{ __('Register') }}</Link>
                    @endif
                @endauth
            </div>
        @endif

        <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-6">
                    <div class="flex items-center">
                        <svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="System / Save">
                            <path id="Vector" d="M17 21.0002L7 21M17 21.0002L17.8031 21C18.921 21 19.48 21 19.9074 20.7822C20.2837 20.5905 20.5905 20.2843 20.7822 19.908C21 19.4806 21 18.921 21 17.8031V9.21955C21 8.77072 21 8.54521 20.9521 8.33105C20.9095 8.14 20.8393 7.95652 20.7432 7.78595C20.6366 7.59674 20.487 7.43055 20.1929 7.10378L17.4377 4.04241C17.0969 3.66374 16.9242 3.47181 16.7168 3.33398C16.5303 3.21 16.3242 3.11858 16.1073 3.06287C15.8625 3 15.5998 3 15.075 3H6.2002C5.08009 3 4.51962 3 4.0918 3.21799C3.71547 3.40973 3.40973 3.71547 3.21799 4.0918C3 4.51962 3 5.08009 3 6.2002V17.8002C3 18.9203 3 19.4796 3.21799 19.9074C3.40973 20.2837 3.71547 20.5905 4.0918 20.7822C4.5192 21 5.07899 21 6.19691 21H7M17 21.0002V17.1969C17 16.079 17 15.5192 16.7822 15.0918C16.5905 14.7155 16.2837 14.4097 15.9074 14.218C15.4796 14 14.9203 14 13.8002 14H10.2002C9.08009 14 8.51962 14 8.0918 14.218C7.71547 14.4097 7.40973 14.7155 7.21799 15.0918C7 15.5196 7 16.0801 7 17.2002V21M15 7H9" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                        </svg>
                        <div class="ml-4 text-lg leading-7 font-semibold">{{ __('Save your Personal Documents') }}</div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 text-sm">
                            {{ __('With Dokumento! you can store your personal documents. You can store any type of file. You can proctect your documents with aditional passkey.') }}
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                    <div class="flex items-center">
                        <svg width="18px" height="18px" viewBox="0 -0.5 21 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                              <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Dribbble-Light-Preview" transform="translate(-179.000000, -280.000000)" fill="#000000">
                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                        <path d="M128.93985,132.929 L130.42455,134.343 L124.4847,140 L123,138.586 L128.93985,132.929 Z M136.65,132 C133.75515,132 131.4,129.757 131.4,127 C131.4,124.243 133.75515,122 136.65,122 C139.54485,122 141.9,124.243 141.9,127 C141.9,129.757 139.54485,132 136.65,132 L136.65,132 Z M136.65,120 C132.5907,120 129.3,123.134 129.3,127 C129.3,130.866 132.5907,134 136.65,134 C140.7093,134 144,130.866 144,127 C144,123.134 140.7093,120 136.65,120 L136.65,120 Z" id="search_right-[#1507]"></path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <div class="ml-4 text-lg leading-7 font-semibold">{{ __('Find your documents simply and quickly.') }}</div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 text-sm">
                            {{ __('Find your documents simply and quickly. You can download your document any time.') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
            <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                v0.1 (Laravel v{{ Illuminate\Foundation\Application::VERSION }} PHP v{{ PHP_VERSION }})
            </div>
        </div>
        <br><br><br><br><br><br>
    </div>
</div>