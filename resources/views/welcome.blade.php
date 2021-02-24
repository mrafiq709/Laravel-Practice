<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- ... --->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
    <body>
        <div class="border border-blue-300 shadow rounded-md p-4 max-w-sm w-full mx-auto">
            <div class="animate-pulse flex space-x-4">
                <div class="rounded-full bg-blue-400 h-12 w-12"></div>
                <div class="flex-1 space-y-4 py-1">
                <div class="h-4 bg-blue-400 rounded w-3/4"></div>
                <div class="space-y-2">
                    <div class="h-4 bg-blue-400 rounded"></div>
                    <div class="h-4 bg-blue-400 rounded w-5/6"></div>
                </div>
                </div>
            </div>
        </div>
        <div class="relative overflow-hidden mb-8"><div class="rounded-t-xl overflow-hidden bg-gradient-to-r from-rose-50 to-rose-100 p-10">
            <div class="flex justify-around">
                <span class="inline-flex rounded-md shadow-sm">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-rose-600 hover:bg-rose-500 focus:border-rose-700 active:bg-rose-700 transition ease-in-out duration-150 cursor-not-allowed" disabled="">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing
                </button>
                </span>
            </div>
        </div>
        <div class="flex justify-around">
            <span class="relative inline-flex rounded-md shadow-sm">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-purple-400 text-base leading-6 font-medium rounded-md text-purple-800 bg-white hover:text-purple-700 focus:border-purple-300 transition ease-in-out duration-150">
                Transactions
            </button>
            <span class="flex absolute h-3 w-3 top-0 right-0 -mt-1 -mr-1">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-purple-500"></span>
            </span>
            </span>
        </div>

        <!-- Blade component -->
        @php $message = "something is going wrong !"; $title = "Holy smokes!"; @endphp
        <div class="mr-300">
        <x-alert type="red" :title="$title" :message="$message"/>
        </div>
        <x-modern-with-badge type="indigo" :title="$title" :message="$message"/>

        <div class="py-8 px-8">
            <div class="py-8 px-8 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-2 sm:py-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-6">
                <img class="block mx-auto h-24 rounded-full sm:mx-0 sm:flex-shrink-0" src="ft34.jpg" alt="Woman's Face">
                <div class="text-center space-y-2 sm:text-left">
                    <div class="space-y-0.5">
                    <p class="text-lg text-black font-semibold">
                        Erin Lindford
                    </p>
                    <p class="text-gray-500 font-medium">
                        Product Engineer
                    </p>
                    </div>
                    <button class="px-4 py-1 text-sm text-purple-600 font-semibold rounded-full border border-purple-200 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">Message</button>
                </div>
            </div>
        </div>

        <div class="rounded-t-xl overflow-hidden bg-gradient-to-r from-indigo-50 to-indigo-100 p-10">
            <div class="group px-6 py-5 max-w-full mx-auto w-72 border border-indigo-500 border-opacity-25 cursor-pointer rounded-lg select-none overflow-hidden space-y-1 hover:bg-white hover:shadow-lg hover:border-transparent">
                <p class="font-semibold text-lg text-indigo-600 group-hover:text-gray-900">New Project</p>
                <p class="text-indigo-500 group-hover:text-gray-500">Create a new project from a variety of starting templates.</p>
            </div>
        </div>

    </body>
</html>
