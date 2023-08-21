<template>
  <div>
    <Head title="New Call Flow Step" />

    <Heading class="mb-6">Create Call Flow Step</Heading>

    <div class=" bg-white border sm:p-6 sm:rounded-lg w-72 mx-auto p-20 " style="text-align:center">
        <!-- <img src="https://v2.callscaler.com/call-flow.jpg" class="mx-auto w-10 flex items-center"> -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1CC1CC"  class="mx-auto w-10 flex items-center">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75v-4.5m0 4.5h4.5m-4.5 0l6-6m-3 18c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 014.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 00-.38 1.21 12.035 12.035 0 007.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 011.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 01-2.25 2.25h-2.25z" />
        </svg>

        <h2 class="mt-2 text-lg font-medium text-gray-900"> New Call is Received</h2>
        <p class="mt-1 text-md text-gray-500">
            What should happen next?
        </p>
    </div>

    <div class="border-2-2 absolute border-opacity-20 bg-gray-300 h-8 border mx-auto" style="left: 58.2%"></div>

    <div class="bg-white  sm:p-6 sm:rounded-lg space-y-6 mt-8 w-3/4 mx-auto shadow shadow-2xl" v-if="open == true">
            <div class="max-w-md mx-auto sm:max-w-3xl">
                <div class="text-center">
                    <h2 class="text-md font-medium text-gray-900"> Add a next step to your call flow</h2>
                </div>
                <div class="mt-2">
                    <ul role="list" class="mt-1 grid grid-cols-1 gap-4 sm:grid-cols-5">
                        <li>
                            <button type="button" @click="open = false; greeting_show = true; $refs.header.scrollIntoView({ behavior: 'smooth' })" wire:click="store('greeting');" class="group p-2 w-full h-24 text-black
                             justify-between text-center rounded-lg shadow-sm space-x-3 bg-callFlowWidgetBackground
                                text-left hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo">
                                <span class="min-w-0 flex-1 space-x-3 my-auto">
                                    <span class="block flex-shrink-0">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-CallScalerIndigo" viewBox="0 0 20 20" fill="#1CC1CC">
                                            <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                      </svg>
                                    </span>
                                    <span class="block min-w-0 flex-1">
                                        <span class="block text-md font-medium truncate text-gray-500 mr-3">Greeting</span>
                                    </span>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button type="button" @click="open = false; forward_call_show = true;" wire:click="store('call_forwarding')" class="group p-2 w-full
                              rounded-lg shadow-sm space-x-3 text-left hover:bg-gray-50 focus:outline-none focus:ring-2
                               focus:ring-offset-2 focus:ring-CallScalerIndigo text-center h-24 text-black bg-callFlowWidgetBackground">
                                <span class="min-w-0 flex-1 space-x-3">
                                    <span class="block flex-shrink-0 ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-CallScalerIndigo" viewBox="0 0 20 20" fill="#1CC1CC">
                                              <path d="M17.924 2.617a.997.997 0 00-.215-.322l-.004-.004A.997.997 0 0017 2h-4a1 1 0 100 2h1.586l-3.293 3.293a1 1 0 001.414 1.414L16 5.414V7a1 1 0 102 0V3a.997.997 0 00-.076-.383z"></path>
                                              <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                        </svg>
                                    </span>
                                    <span class="block min-w-0 flex-1">
                                        <span class="block text-md font-medium truncate text-gray-500">Forward call</span>
                                    </span>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button type="button" wire:click="store('voicemail')" @click="open = false; voicemail_show = true;" class="group p-2 w-full
                             rounded-lg shadow-sm space-x-3 text-left hover:bg-gray-50 focus:outline-none focus:ring-2
                             focus:ring-offset-2 focus:ring-CallScalerIndigo text-center h-24 bg-callFlowWidgetBackground">

                                   <span class="min-w-0 flex-1 space-x-3">
                                    <span class="block flex-shrink-0">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-CallScalerIndigo" viewBox="0 0 20 20" fill="#1CC1CC">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                        </svg>

                                    </span>
                                    <span class="block min-w-0 flex-1">
                                        <span class="block text-md font-medium truncate text-gray-500 mr-3">Voicemail</span>
                                    </span>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button type="button" wire:click="store('multi_ringing')" @click="open = false; multi_ringing_show = true" class="group p-2 w-full
                                     rounded-lg shadow-sm space-x-3 text-left hover:bg-gray-50 focus:outline-none focus:ring-2
                                     focus:ring-offset-2 focus:ring-CallScalerIndigo text-center h-24 bg-callFlowWidgetBackground">
                                    <span class="min-w-0 flex-1 space-x-3">
                                        <span class="block flex-shrink-0">
                                           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto text-CallScalerIndigo" viewBox="0 0 20 20" fill="#1CC1CC">
                                              <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                          </svg>

                                    </span>
                                    <span class="block min-w-0 flex-1">
                                        <span class="block text-md font-medium truncate text-gray-500 mr-3">Multi ringing</span>
                                        </span>
                                    </span>

                            </button>
                        </li>
                        <li>
                            <button type="button" wire:click="store('call_tree')" @click="open = false; call_tree_menu_show = true" class="group p-2 w-full
                                     rounded-lg shadow-sm space-x-3 text-left hover:bg-gray-50 focus:outline-none focus:ring-2
                                     focus:ring-offset-2 focus:ring-CallScalerIndigo text-center h-24 bg-callFlowWidgetBackground">
                                    <div class="min-w-0 flex-1 space-x-3 rotate-45">
                                        <span class="block flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#1CC1CC" class="h-6 w-6 mx-auto text-CallScalerIndigo">
                                                <path fill-rule="evenodd" d="M15.75 4.5a3 3 0 11.825 2.066l-8.421 4.679a3.002 3.002 0 010 1.51l8.421 4.679a3 3 0 11-.729 1.31l-8.421-4.678a3 3 0 110-4.132l8.421-4.679a3 3 0 01-.096-.755z" clip-rule="evenodd"></path>
                                            </svg>
                                        </span>


                                    </div>
                                    <span class="block min-w-0 flex-1">
                                        <span class="block text-md font-medium truncate text-gray-500 mr-3 ">Call Tree</span>
                                    </span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div x-show="parent_greeting" v-if="greeting_show == true" class="bg-white my-8 shadow-xl sm:p-6 sm:rounded-lg space-y-6 w-3/6 mx-auto">
            <div x-ref="header" class="block w-full rounded-lg text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-auto text-CallScalerIndigo" viewBox="0 0 20 20" fill="#1CC1CC">
                        <path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    <h2 class="text-lg font-medium text-gray-900">
                        Greeting
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 text-center">
                        Use text to speech or play an audio file to your caller.
                    </p>
                    <div class="border-gray-200 py-3 flex items-center">
                        <fieldset class="">
                            <div class="space-y-4 sm:flex sm:items-center
                                sm:space-y-0 sm:space-x-10">
                                <div class="flex items-center">
                                    <input id="type_text-0" wire:model="greetingWidgetType.0" value="text_to_speech" @change="greeting_text()" type="radio"  v-model="greeting_type" class="focus:ring-CallScalerIndigo h-4 w-4 text-CallScalerIndigo border-gray-300">
                                    <label for="type_text-0" class="ml-3 block text-sm font-medium text-gray-700">
                                        Text to Speech
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input @change="greeting_audio()" id="type_audio-0" type="radio" value="play_audio" wire:model="greetingWidgetType.0" v-model="greeting_type"  class="focus:ring-CallScalerIndigo h-4 w-4 text-CallScalerIndigo border-gray-300">
                                    <label for="type_audio-0" class="ml-3 block text-sm font-medium text-gray-700">
                                        Play Audio
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div  v-if="textShowGreeting == true">
                        <div class="mt-1">
                            <textarea wire:model="greetingWidgetMessage.0" rows="2" id="message-0" v-model="greeting_text_to_speech_message" placeholder="Message will be spoken to caller" class="shadow-sm block w-full sm:text-sm border-input rounded-md"></textarea>
                        </div>
                    </div>
                    <div v-if="audioShowGreeting == true">
                        <div class="sm:col-span-6">
                            <div class="mt-1 flex justify-center px-2 pt-1 pb-2 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-8 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload-0" class="relative cursor-pointer bg-white rounded-md font-medium text-CallScalerIndigo hover:ring-CallScalerIndigo focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-CallScalerIndigo">
                                            <span>Upload a file</span>
                                            <input id="file-upload-0" :value="value" type="file" @change="changeFileGreeting" ref="fileGreeeting" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        WAV, MP3 up to 10MB
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-data="{open: false }" class="mt-5 sm:mt-3 sm:grid col-end-4 lg:grid-cols-4 sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <button @click="submit('greeting')" type="button" style="background-color:#1CC1CC;" class="w-full inline-flex justify-center lg:col-start-4 rounded-md border border-transparent
                                shadow-sm px-4 py-2 bg-CallScalerIndigo text-base font-medium text-white hover:bg-CallScalerHover
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:CallScalerBg sm:col-start-2 sm:text-sm
                                ">
                            Save
                        </button>
                        <button @click="open = true; greeting_show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium text-black hover:bg-gray-50 sm:mt-0 lg:col-start-3 sm:col-start-1 sm:text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:CallScalerBg">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="parent_forwarding_call_div" v-if="forward_call_show == true" class="bg-white my-8  shadow-xl sm:p-6 sm:rounded-lg space-y-6 w-3/6 mx-auto">
            <div x-ref="header" class="max-w-md mx-auto sm:max-w-3xl">
                <div class=" block w-full rounded-lg  text-center
                    hover:border-gray-400
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerBg">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-auto text-CallScalerIndigo" viewBox="0 0 20 20" fill="#1CC1CC">
                            <path d="M17.924 2.617a.997.997 0 00-.215-.322l-.004-.004A.997.997 0 0017 2h-4a1 1 0 100 2h1.586l-3.293 3.293a1 1 0 001.414 1.414L16 5.414V7a1 1 0 102 0V3a.997.997 0 00-.076-.383z"></path>
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                        <h2 class="text-lg font-medium text-gray-900">
                            Forward Call
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 text-center">
                            Forward the incoming call to a specific number.
                        </p>
                        <div class="mt-1 border-gray-200 py-6 space-x-4 ">
                            <div class="">
                                <div class="relative mt-1 rounded-md shadow-sm w-3/5 mx-auto">
                                    <phone-number  :class="{'border-error':!forward_number && !isValid,}" class="border-input h-10 outline-none w-full px-3 text-sm leading-normal bg-white dark:bg-gray-700 rounded-t border-b border-gray-200 dark:border-gray-800" :value="forward_call_forward_number" v-model="forward_call_forward_number" id="forward_number" required />
                                </div>
                            </div>
                            <div class="flex mt-8">
                                <label for="call-forwarding-wait-0" class="block text-sm font-medium text-gray-700 text-left">Wait
                                    <select wire:model="callForwardingWidgetWaitingTime.0" v-model="forward_call_wait" id="call-forwarding-wait-0" class="mt-1 w-3/12   py-2 text-base border-input focus:outline-none sm:text-sm rounded-md">
                                        <option value="10">10 Sec's</option>
                                        <option selected="selected" value="20">20 Sec's</option>
                                        <option value="30">30 Sec's</option>
                                        <option value="40">40 Sec's</option>
                                        <option value="50">50 Sec's</option>
                                    </select>
                                    then move to next step if no one answers.
                                </label>
                            </div>
                        </div>
                        <div x-data="{open: false }" class="mt-5 sm:mt-3 sm:grid col-end-4 lg:grid-cols-4 sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                            <button @click="submit('forward-call')" type="button" style="background-color:#1CC1CC;" class="w-full inline-flex justify-center lg:col-start-4 rounded-md border border-transparent
                                shadow-sm px-4 py-2 bg-CallScalerIndigo text-base font-medium text-white hover:bg-CallScalerHover
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:CallScalerBg sm:col-start-2 sm:text-sm
                                    ">
                                Save
                            </button>
                            <button type="button" @click="open = true; forward_call_show = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300
                                            shadow-sm px-4 py-2 text-base font-medium text-black
                                            hover:bg-gray-50 sm:mt-0 lg:col-start-3 sm:col-start-1 sm:text-sm
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:CallScalerBg
                                        ">
                                Cancel
                            </button>
                            <div x-show="open" style="display: none;" aria-live="assertive" class="fixed inset-0 flex items-end px-4 py-6 sm:p-6 sm:items-start z-10">
                                <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
                                    <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5">
                                        <div class="p-4">
                                            <div class="flex items-start">
                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                    <!-- Heroicon name: outline/exclamation -->
                                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-3 w-0 flex-1 items-start">
                                                    <h3 class="font-bold text-left">Delete Step</h3>
                                                    <p class="mt-1 whitespace-pre-line text-sm text-gray-500 text-left">Do you really want to delete this step?</p>
                                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                                        <button wire:click="destroy(0)" @click="open= false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Delete</button>
                                                        <button @click="open= false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-shrink-0 flex">
                                                    <button class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo">
                                                        <span class="sr-only">Close</span>
                                                        <!-- Heroicon name: solid/x -->
                                                        <svg @click="open= false" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="parent_voicemail" v-if="voicemail_show == true" class="bg-white my-8 shadow-xl sm:p-6 sm:rounded-lg space-y-6 w-3/6 mx-auto">
            <div x-ref="header" class="block w-full rounded-lg text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-auto text-CallScalerIndigo" viewBox="0 0 20 20" fill="#1CC1CC">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                    </svg>
                    <h2 class="text-lg font-medium text-gray-900">
                        Voicemail
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 text-center">
                        Use text to speech or play an audio file to your voicemail.
                    </p>
                    <div class="border-gray-200 py-3 flex items-center">
                        <fieldset class="">
                            <div class="space-y-4 sm:flex sm:items-center
                                sm:space-y-0 sm:space-x-10">
                                <div class="flex items-center">
                                    <input id="type_text-0" wire:model="greetingWidgetType.0" value="text_to_speech" @change="vm_text()" type="radio"  v-model="voicemail_type" class="focus:ring-CallScalerIndigo h-4 w-4 text-CallScalerIndigo border-gray-300">
                                    <label for="type_text-0" class="ml-3 block text-sm font-medium text-gray-700">
                                        Text to Speech
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input @change="vm_audio()" id="type_audio-0" type="radio" value="play_audio" wire:model="greetingWidgetType.0" v-model="voicemail_type"  class="focus:ring-CallScalerIndigo h-4 w-4 text-CallScalerIndigo border-gray-300">
                                    <label for="type_audio-0" class="ml-3 block text-sm font-medium text-gray-700">
                                        Play Audio
                                    </label>
                                </div>
                            </div>

                        </fieldset>
                    </div>
                    <div  v-if="textShowVm == true">
                        <div class="mt-1">
                            <textarea wire:model="greetingWidgetMessage.0" rows="2" v-model="voicemail_text_to_speech_message" id="message-0" placeholder="Message will be spoken and then a beep will play to start the voicemail recording" class="shadow-sm block w-full sm:text-sm rounded-md border-input"></textarea>
                        </div>
                    </div>
                    <div v-if="audioShowVm == true">
                        <div class="sm:col-span-6">
                            <div class="mt-1 flex justify-center px-2 pt-1 pb-2 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-8 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload-0" class="relative cursor-pointer bg-white rounded-md font-medium text-CallScalerIndigo hover:ring-CallScalerIndigo focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-CallScalerIndigo">
                                            <span>Upload a file</span>
                                            <input wire:model="greetingWidgetAudioFile.0" @change="changeFileVm" id="file-upload-0" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        WAV, MP3 up to 10MB
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="voicemail-sms-notification-0" class="block text-sm font-medium text-gray-700 text-left">Send an email notification with a voicemail recording link.
                        </label>
                        <div class="mt-1">
                            <input wire:model="voicemailSmsNotificationNumber.0" type="email" v-model="voicemail_email" id="voicemail-sms-notification-0" style="height: 40px;" class="shadow-sm focus:ring-CallScalerIndigo focus:border-CallScalerIndigo
                                block w-full sm:text-sm border-input rounded-md" placeholder="Please enter email address">
                        </div>

                    </div>

                    <div x-data="{open: false }" class="mt-5 sm:mt-3 sm:grid col-end-4 lg:grid-cols-4 sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <button @click="submit('voicemail')" type="button" style="background-color:#1CC1CC;" class="w-full inline-flex justify-center lg:col-start-4 rounded-md border border-transparent
                                shadow-sm px-4 py-2 bg-CallScalerIndigo text-base font-medium text-white hover:bg-CallScalerHover
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:CallScalerBg sm:col-start-2 sm:text-sm
                                ">
                            Save
                        </button>

                        <button @click="open = true; voicemail_show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300
                                            shadow-sm px-4 py-2 text-base font-medium text-black
                                            hover:bg-gray-50 sm:mt-0 lg:col-start-3 sm:col-start-1 sm:text-sm
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:CallScalerBg
                                            ">
                            Cancel
                        </button>
                        <div x-show="open" style="display: none;" aria-live="assertive" class="fixed inset-0 flex items-end px-4 py-6 sm:p-6 sm:items-start z-10">
                            <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
                                <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5">
                                    <div class="p-4">
                                        <div class="flex items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <!-- Heroicon name: outline/exclamation -->
                                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3 w-0 flex-1 items-start">
                                                <h3 class="font-bold text-left">Delete Step</h3>
                                                <p class="mt-1 whitespace-pre-line text-sm text-gray-500 text-left">Do you really want to delete this step?</p>
                                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                                    <button wire:click="destroy(0)" @click="open= false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Delete</button>
                                                    <button @click="open= false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-shrink-0 flex">
                                                <button class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo">
                                                    <span class="sr-only">Close</span>
                                                    <!-- Heroicon name: solid/x -->
                                                    <svg @click="open= false" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>


        </div>

        <div x-show="parent_multi_ringing_div" v-if="multi_ringing_show == true" class="bg-white my-8  shadow-xl sm:p-6 sm:rounded-lg space-y-6 w-3/6 mx-auto">

            <div x-ref="header" class="max-w-md mx-auto sm:max-w-3xl">
                <div class="relative block w-full rounded-lg text-center
                                        hover:border-gray-400
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mx-auto text-CallScalerIndigo" viewBox="0 0 20 20" fill="#1CC1CC">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                        <h2 class="text-lg font-medium text-gray-900">
                            Multi Ringing
                        </h2>
                        <p class="mt-1 text-sm text-center text-gray-500">
                            Call forwarding that involves multiple recipients.
                        </p>

                        <div class="border-gray-200 py-3 flex items-center">
                            <fieldset class="">
                                <div class="space-y-4 sm:flex sm:items-center
                                    sm:space-y-0 sm:space-x-10">

                                    <div class="flex items-center">
                                        <input id="type_text-0" wire:model="multiRingingWidgetType.0" value="simul-ringing" @change="mr_simul_ringing()" type="radio"  v-model="multi_ringing_type" class="focus:ring-CallScalerIndigo h-4 w-4 text-CallScalerIndigo border-gray-300">
                                        <label for="type_text-0" class="ml-3 block text-sm font-medium text-gray-700">
                                            Simul Ringing
                                        </label>
                                    </div>

                                    <div class="flex items-center">
                                        <input @change="mr_round_robin()" id="type_audio-0" type="radio" value="round-robin" wire:model="multiRingingWidgetType.0" v-model="multi_ringing_type"  class="focus:ring-CallScalerIndigo h-4 w-4 text-CallScalerIndigo border-gray-300">
                                        <label for="type_audio-0" class="ml-3 block text-sm font-medium text-gray-700">
                                            Round Robin
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div v-if="simulRingingShow == true">
                            <div class="mt-1">
                                <textarea v-model="multi_ringing_phone_numbers" rows="3" placeholder="Ring multiple phone numbers simultaneously, and the first one to answer the call gets connected." id="multi-ringing-numbers-0" class="shadow-sm block w-full sm:text-sm border-input rounded-md"></textarea>
                            </div>
                            <span class="block text-xs font-medium text-gray-700 text-left">You can add up to 10 numbers which are separated by commas.</span>
                        </div>
                        <div v-if="roundRobinShow == true">
                            <div class="mt-1">
                                <textarea v-model="multi_ringing_phone_numbers" rows="3" placeholder="Evenly distribute calls between multiple recipients. For example, if two numbers are set up in your Round Robin, the first call will go to Recipient A. The next call will go to Recipient B." id="multi-ringing-numbers-0" class="shadow-sm block w-full sm:text-sm border-input rounded-md"></textarea>
                            </div>
                            <span class="block text-xs font-medium text-gray-700 text-left">You can add up to 10 numbers which are separated by commas.</span>
                        </div>

                        <div x-data="{open: false }" class="mt-5 sm:mt-3 sm:grid col-end-4 lg:grid-cols-4 sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                            <button @click="submit('multi-ringing')" type="button" style="background-color:#1CC1CC;" class="w-full inline-flex justify-center lg:col-start-4 rounded-md border border-transparent
                                shadow-sm px-4 py-2 bg-CallScalerIndigo text-base font-medium text-white hover:bg-CallScalerHover
                                focus:outline-none focus:ring-2 focus:ring-offset-2focus:CallScalerBg sm:col-start-2 sm:text-sm
                                ">
                                Save
                            </button>
                            <button type="button" @click="open = true; multi_ringing_show = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300
                                            shadow-sm px-4 py-2 text-base font-medium text-black
                                            hover:bg-gray-50 sm:mt-0 lg:col-start-3 sm:col-start-1 sm:text-sm
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:CallScalerBg
                                            ">
                                Cancel
                            </button>
                            <div x-show="open" style="display: none;" aria-live="assertive" class="fixed inset-0 flex items-end px-4 py-6 sm:p-6 sm:items-start z-10">
                                <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
                                    <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5">
                                        <div class="p-4">
                                            <div class="flex items-start">
                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                    <!-- Heroicon name: outline/exclamation -->
                                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-3 w-0 flex-1 items-start">
                                                    <h3 class="font-bold text-left">Delete Step</h3>
                                                    <p class="mt-1 whitespace-pre-line text-sm text-gray-500 text-left">Do you really want to delete this step?</p>
                                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                                        <button wire:click="destroy(0)" @click="open= false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Delete</button>
                                                        <button @click="open= false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-shrink-0 flex">
                                                    <button class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo">
                                                        <span class="sr-only">Close</span>
                                                        <!-- Heroicon name: solid/x -->
                                                        <svg @click="open= false" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div x-show="parent_call_tree_menu" v-if="call_tree_menu_show == true" class="bg-white my-8 shadow-xl sm:p-6 sm:rounded-lg space-y-6 w-3/6 mx-auto">

            <div x-ref="header" class="block w-full rounded-lg text-center
                hover:border-gray-400
                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#1CC1CC" class="h-7 w-7 mx-auto text-CallScalerIndigo">
                        <path fill-rule="evenodd" d="M15.75 4.5a3 3 0 11.825 2.066l-8.421 4.679a3.002 3.002 0 010 1.51l8.421 4.679a3 3 0 11-.729 1.31l-8.421-4.678a3 3 0 110-4.132l8.421-4.679a3 3 0 01-.096-.755z" clip-rule="evenodd"></path>
                    </svg>

                    <h2 class="text-lg font-medium text-gray-900">
                        Call Tree Menu
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 text-center">
                        Direct callers to the correct department
                    </p>

                    <div class="border-gray-200 py-3 flex items-center">
                        <fieldset class="">
                            <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                <div class="flex items-center">
                                    <input id="type_text-0" value="text_to_speech" @change="call_tree_text()" type="radio"  v-model="call_tree_type" class="focus:ring-CallScalerIndigo h-4 w-4 text-CallScalerIndigo border-gray-300">
                                    <label for="type_text-0" class="ml-3 block text-sm font-medium text-gray-700">
                                        Text to Speech
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input @change="call_tree_audio()" id="type_audio-0" type="radio" value="play_audio" v-model="call_tree_type"  class="focus:ring-CallScalerIndigo h-4 w-4 text-CallScalerIndigo border-gray-300">
                                    <label for="type_audio-0" class="ml-3 block text-sm font-medium text-gray-700">
                                        Play Audio
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <!--Textarea for text to speech-->
                    <div  v-if="textShowCallTree == true">
                        <div class="mt-1">
                            <textarea v-model="call_tree_text_to_speech_message" rows="2" id="message-0" placeholder="Write your greeting here (i.e. Press 1 to connect our billing department, press 2 to get connected to sales, etc...)" class="shadow-sm block w-full sm:text-sm
                                border-input rounded-md"></textarea>
                        </div>
                    </div>

                    <!-- Upload file to greet caller -->
                    <div v-if="audioShowCallTree == true">

                        <div class="sm:col-span-6">
                            <div class="mt-1 flex justify-center px-2 pt-1 pb-2
                                            border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-8 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="file-upload-0" class="relative cursor-pointer bg-white rounded-md font-medium text-CallScalerIndigo hover:ring-CallScalerIndigo focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-CallScalerIndigo">
                                            <span>Upload a file</span>
                                            <input @change="changeFileCallTree" id="file-upload-0" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        WAV, MP3 up to 10MB
                                    </p>
                                                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="tree-forward-number-0" class="block text-sm font-medium text-gray-700 text-left">If 1 is dialed, the call will get
                            forwarded to:
                        </label>
                        <div class="mt-1">
                            <!-- <input wire:model.defer="treeForwardNumber.0.1" type="text" name="forwardnumber" id="tree-forward-number-0" class="shadow-sm focus:ring-CallScalerIndigo focus:border-CallScalerIndigo block w-full sm:text-sm border-gray-300 rounded-md" placeholder="(444) 444-4441"> -->

                            <phone-number  class="hadow-sm focus:ring-CallScalerIndigo focus:border-CallScalerIndigo block w-full sm:text-sm border-input rounded-md" :value="call_tree_forward_number_one" v-model="call_tree_forward_number_one" id="forward_number" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="tree-forward-number-0" class="block text-sm font-medium text-gray-700 text-left">If 2 is dialed, the call will get
                            forwarded to:
                        </label>
                        <div class="mt-1">
                            <!-- <input wire:model.defer="treeForwardNumber.0.2" type="text" name="forwardnumber" id="tree-forward-number-0.2" class="shadow-sm focus:ring-CallScalerIndigo focus:border-CallScalerIndigo
                                block w-full sm:text-sm border-gray-300 rounded-md" placeholder="(444) 444-4442"> -->

                            <phone-number  class="hadow-sm focus:ring-CallScalerIndigo focus:border-CallScalerIndigo block w-full sm:text-sm border-input rounded-md" :value="call_tree_forward_number_two" v-model="call_tree_forward_number_two" id="forward_number" />
                        </div>
                    </div>

                    <div x-data="{open: false }" class="mt-5 sm:mt-3 sm:grid col-end-4 lg:grid-cols-4 sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                        <button @click="submit('call-tree-menu')" type="button" style="background-color:#1CC1CC;" class="w-full inline-flex justify-center lg:col-start-4 rounded-md border border-transparent
                                shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:CallScalerBg sm:col-start-2 sm:text-sm
                                ">
                            Save
                        </button>

                        <button @click="open = true; call_tree_menu_show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300
                                            shadow-sm px-4 py-2 text-base font-medium text-black
                                            hover:bg-gray-50 sm:mt-0 lg:col-start-3 sm:col-start-1 sm:text-sm
                                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:CallScalerBg
                                            ">
                            Cancel
                        </button>
                        <div x-show="open" style="display: none;" aria-live="assertive" class="fixed inset-0 flex items-end px-4 py-6 sm:p-6 sm:items-start z-10">
                            <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
                                <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5">
                                    <div class="p-4">
                                        <div class="flex items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <!-- Heroicon name: outline/exclamation -->
                                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3 w-0 flex-1 items-start">
                                                <h3 class="font-bold text-left">Delete Step</h3>
                                                <p class="mt-1 whitespace-pre-line text-sm text-gray-500 text-left">Do you really want to delete this step?</p>
                                                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                                    <button wire:click="destroy(0)" @click="open= false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Delete</button>
                                                    <button @click="open= false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-shrink-0 flex">
                                                <button class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-CallScalerIndigo">
                                                    <span class="sr-only">Close</span>
                                                    <!-- Heroicon name: solid/x -->
                                                    <svg @click="open= false" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>


        </div>
    <!-- <Card
      class="flex flex-col items-center justify-center"
      style="min-height: 300px"
    >
      <svg
        class="spin fill-80 mb-6"
        width="69"
        height="72"
        viewBox="0 0 23 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M20.12 20.455A12.184 12.184 0 0 1 11.5 24a12.18 12.18 0 0 1-9.333-4.319c4.772 3.933 11.88 3.687 16.36-.738a7.571 7.571 0 0 0 0-10.8c-3.018-2.982-7.912-2.982-10.931 0a3.245 3.245 0 0 0 0 4.628 3.342 3.342 0 0 0 4.685 0 1.114 1.114 0 0 1 1.561 0 1.082 1.082 0 0 1 0 1.543 5.57 5.57 0 0 1-7.808 0 5.408 5.408 0 0 1 0-7.714c3.881-3.834 10.174-3.834 14.055 0a9.734 9.734 0 0 1 .03 13.855zM4.472 5.057a7.571 7.571 0 0 0 0 10.8c3.018 2.982 7.912 2.982 10.931 0a3.245 3.245 0 0 0 0-4.628 3.342 3.342 0 0 0-4.685 0 1.114 1.114 0 0 1-1.561 0 1.082 1.082 0 0 1 0-1.543 5.57 5.57 0 0 1 7.808 0 5.408 5.408 0 0 1 0 7.714c-3.881 3.834-10.174 3.834-14.055 0a9.734 9.734 0 0 1-.015-13.87C5.096 1.35 8.138 0 11.5 0c3.75 0 7.105 1.68 9.333 4.319C16.06.386 8.953.632 4.473 5.057z"
          fill-rule="evenodd"
        />
      </svg>

      <h1 class="dark:text-white text-4xl font-light mb-6">
        We're in a black hole.
      </h1>

      <p class="dark:text-white text-lg opacity-70">
        You can edit this tool's component at:
        <code
          class="ml-1 border border-gray-100 dark:border-gray-900 text-sm font-mono text-white bg-black rounded px-2 py-1"
        >
          /nova-components/NewCallFlowStep/resources/js/pages/Tool.vue
        </code>
      </p>
    </Card> -->
  </div>
</template>

<script>
import axios from "axios";
import PhoneNumber from '../components/PhoneNumber.vue';
export default {
  components: {
        PhoneNumber,
        // VueFormStepper,
  },
  props: ['id'],
  mounted() {
    //
  },
  data() {
        return {
            name : null,
            call_flows: {},
            call_flow_id: null,
            step: null,
            open: true,
            textShowGreeting: false,
            audioShowGreeting: false,
            textShowCallTree: false,
            audioShowCallTree: false,
            textShowVm: false,
            audioShowVm: false,
            call_flow_type: null,
            greeting_show: false,
            greeting_type: null,
            greeting_text_to_speech_message: null,
            greeting_audio_file_path: null,
            forward_call_show: false,
            forward_call_forward_number: null,
            forward_call_wait: 20,
            voicemail_show: false,
            voicemail_type: null,
            voicemail_text_to_speech_message: null,
            voicemail_audio_file_path: null,
            voicemail_email: null,
            multi_ringing_show: false,
            multi_ringing_type: null,
            multi_ringing_phone_numbers: null,
            call_tree_menu_show: false,
            call_tree_type: null,
            call_tree_text_to_speech_message: null,
            call_tree_audio_file_path: null,
            call_tree_forward_number_one: null,
            call_tree_forward_number_two: null,
            greeting_text_to_speech_show: false,
            greeting_play_audio_show: false,
            voicemail_text_to_speech_show: false,
            voicemail_play_audio_show: false,
            call_tree_text_to_speech_show: false,
            call_tree_play_audio_show: false,
            simulRingingShow: false,
            roundRobinShow: false,
            greetingFile: null,
            vmFile: null,
            callTreeFile: null,
        };
  },
  methods: {
    greeting_audio()
    {
        this.textShowGreeting = false;
        this.audioShowGreeting = true;
    },
    greeting_text()
    {
        this.textShowGreeting = true;
        this.audioShowGreeting = false;
    },
    vm_audio()
    {
        this.textShowVm = false;
        this.audioShowVm = true;
    },
    vm_text()
    {
        this.textShowVm = true;
        this.audioShowVm = false;
    },
    mr_simul_ringing()
    {
        this.simulRingingShow = true;
        this.roundRobinShow = false;
    },
    mr_round_robin()
    {
        this.simulRingingShow = false;
        this.roundRobinShow = true;
    },
    call_tree_audio()
    {
        this.textShowCallTree = false;
        this.audioShowCallTree = true;
    },
    call_tree_text()
    {
        this.textShowCallTree = true;
        this.audioShowCallTree = false;
    },
    changeFileGreeting(e)
    {
        this.greetingFile = this.$refs.fileGreeeting.files[0];
        this.validateFile(this.greetingFile);
    },
    changeFileVm(e)
    {
        this.vmFile = e.target.files[0];
        this.validateFile(this.vmFile);
    },
    changeFileCallTree(e)
    {
        this.callTreeFile = e.target.files[0];
        this.validateFile(this.callTreeFile);
    },

    validateFile(file)
    {
        let ext = file.name.substring(file.name.lastIndexOf('.') + 1, file.name.length);
        if(file > 30){
            Nova.error('The file name must be less than 30 characters ');
            return 0;
        }
        if (ext != "mp3" && ext != "wav") {
            Nova.error('The file must be of type .mp3 or .wav');
            return 0;
        }
        if(file.size > 10000000){
            Nova.error('The file size must be less than 10 MB');
            return 0;
        }
    },

    async submit(type)
    {
        let formdata = new FormData;
        const headers = { 'Content-Type': 'multipart/form-data' };
        this.call_flow_type =  type;
        formdata.append('name', this.call_flow_type.charAt(0).toUpperCase() + this.call_flow_type.slice(1));
        formdata.append('call_flow_id', this.id);
        formdata.append('step', 1);
        formdata.append('call_flow_type', this.call_flow_type);

        if (this.call_flow_type == 'greeting') {
            if (this.greeting_type == null) {
                Nova.error("Please Fill Message Field");
                return 0;
            }
            formdata.append('greeting_type', this.greeting_type);

            if (this.greeting_type == 'text_to_speech') {
                formdata.append('greeting_text_to_speech_message', this.greeting_text_to_speech_message);
            }
            else if (this.greeting_type == 'play_audio')
            {
                if (this.greetingFile == null) {
                    Nova.error("Please Add Audio File");
                    return 0;
                }
                formdata.append('greeting_audio',this.greetingFile);
            }
        }
        else if (this.call_flow_type == 'forward-call') {
            if (this.forward_call_forward_number == null) {
                Nova.error("Please Fill Forward Number Field");
                return 0;
            }
            formdata.append('forward_call_forward_number',this.forward_call_forward_number);
            formdata.append('forward_call_wait', this.forward_call_wait);
        }
        else if (this.call_flow_type == 'voicemail') {
            if (this.voicemail_type == null || this.voicemail_email == null) {
                Nova.error("Please Fill All Fields");
                return 0;
            }
            formdata.append('voicemail_type', this.voicemail_type);
            if (this.voicemail_type == 'text_to_speech') {
                if (this.voicemail_text_to_speech_message == null) {
                    Nova.error("Please Fill Message Field");
                    return 0;
                }
                formdata.append('voicemail_text_to_speech_message', this.voicemail_text_to_speech_message);
            } else if (this.voicemail_type == 'play_audio')
            {
                if (this.vmFile == null) {
                    Nova.error("Please Add Audio File");
                    return 0;
                }
                formdata.append('voicemail_audio', this.vmFile);
            }
            formdata.append('voicemail_email', this.voicemail_email);
        }
        else if (this.call_flow_type == 'multi-ringing') {
            if (this.multi_ringing_type == null) {
                Nova.error("Please Select Type");
                return 0;
            }
            if (this.multi_ringing_phone_numbers == null) {
                Nova.error("Please Add Numbers");
                return 0;
            }
            formdata.append('multi_ringing_type', this.multi_ringing_type);
            formdata.append('multi_ringing_phone_numbers', this.multi_ringing_phone_numbers);
        }
        else if (this.call_flow_type == 'call-tree-menu') {
            if (this.call_tree_type == null) {
                Nova.error("Please Select Type");
                return 0;
            }
            formdata.append('call_tree_type', this.call_tree_type);
            if (this.call_tree_type == 'text_to_speech') {
                if (this.call_tree_text_to_speech_message == null) {
                    Nova.error("Please Fill Message Field");
                    return 0;
                }
                formdata.append('call_tree_text_to_speech_message', this.call_tree_text_to_speech_message);
            } else if (this.call_tree_type == 'play_audio')
            {
                if (this.callTreeFile == null) {
                    Nova.error("Please Add Audio File");
                    return 0;
                }
                formdata.append('call_tree_audio', this.callTreeFile);
            }
            formdata.append('call_tree_forward_number_one', this.call_tree_forward_number_one);
            formdata.append('call_tree_forward_number_two', this.call_tree_forward_number_two);
        }

        await Nova.request()
                .post('/nova-api/custom/call-flow-step', formdata, {headers})
                .then((response) => {
                    if (response.status == 200) {
                        if (response.data.status == "success") {
                            Nova.info(response.data.message);
                            Nova.visit("/resources/call-flows");
                        } else {
                            Nova.error("An error accured");
                            Nova.log("Call Flow Step Creation:Error");
                        }
                    }
                })
                .catch((error) => {
                    Nova.error("An error accured!");
                    console.log("Call Flow Step Creation:Error", error);
                });
    },

  },
}
</script>

<style>
.border-input {
    border-color: #80808066;
    --tw-border-opacity: 1;
    border-width: 1px;
}
</style>
