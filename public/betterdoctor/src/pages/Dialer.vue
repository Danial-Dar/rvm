<template>
    <div>
        <div class="p-4 min-h-screen relative">
            <audio id="remoteAudio"></audio>
            <div v-if="callStatus !=='On Call' && callStatus !=='held'">
                
                <div class="flex items-center justify-between">
                    <div>
                        <Status status="Available" />
                    </div>
                    <div>
                        <font-awesome-icon class="text-gray-600 text-3xl" icon="cog" />
                    </div>
                </div>
                <div class="mt-10">
                    <div class="text-center font-bold">
                        <span class="text-lg font-bold">Call Status : </span><span
                            class="text-purple-800 font-bold">{{callStatus}}...</span>
                    </div>
                </div>
                <div class="mt-4 text-center" v-if="showCallRecievingDialog==false">
                    <div class="text-gray-500 font-bold">Type a phone number</div>
                </div>
                <div class="mt-4 text-center">
                    <div class="text-4xl min-w-full h-6">{{phoneNumber}}</div>
                </div>
                <div class="mt-4 dialer" v-if="showCallRecievingDialog==false">
                    <div class="flex flex-wrap justify-center">
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('1')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 active:bg-violet-700 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                1</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('2')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                2</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('3')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                3</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('4')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                4</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('5')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                5</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('6')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                6</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('7')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                7</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('8')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                8</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('9')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                9</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('+')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                +</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="push('0')"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                0</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div @click="backspace()"
                                class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                ⌫</div>
                        </div>
                        <div class="w-1/3 text-center mb-2">
                            <div class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800"
                                @click="call()">
                                <div>
                                    <font-awesome-icon icon="phone" class="transform rotate-90"></font-awesome-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="absolute bottom-0 left-0 p-10 w-full">
                        <div class="flex jusitfy-between w-full">
                            <div @click="answer" class="flex-1 text-center mb-2 mt-16">
                                <div class="mx-auto w-20 h-20 cursor-pointer bg-green-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-gray-100">
                                    <div>
                                        <font-awesome-icon icon="phone" class="transform rotate-90"></font-awesome-icon>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <div v-if="showCallRecievingDialog == false">
                    <div class="mt-4 text-center">
                        <div class="text-4xl min-w-full h-6">{{phoneNumber}}</div>
                    </div>
                    <div class="mt-4 text-center font-bold text-xl">
                        {{zeroPad(minutess, 2) }} : {{zeroPad(secondss, 2)}}
                    </div>
                    <div class="absolute bottom-0 w-full left-0">
                        <div class="flex justify-center">
                            <div class="text-6xl flex-1 flex items-center justify-center">
                                <span @click="unhold" v-if="callStatus == 'held'">
                                    <font-awesome-icon class="cursor-pointer" :icon="['far', 'play-circle']" ></font-awesome-icon>
                                </span>
                                <span @click="hold" v-else>
                                    <font-awesome-icon class="cursor-pointer" :icon="['far', 'pause-circle']" ></font-awesome-icon>
                                </span>
                            </div>
                            <div class="text-6xl flex-1 flex items-center justify-center">
                                <span @click="mute" v-if="muted">
                                    <font-awesome-icon class="cursor-pointer" :icon="['fas', 'volume-up']" ></font-awesome-icon>
                                </span>
                                <span @click="mute" v-else>
                                    <font-awesome-icon class="cursor-pointer" :icon="['fas', 'volume-mute']" ></font-awesome-icon>
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-center items-center mt-8 mb-8">
                            <div class="text-5xl flex-1 flex items-center justify-center ">
                                <div @click="disconnect" class="bg-red-500 p-3 rounded rounded-full cursor-pointer">
                                    <font-awesome-icon class="transform rotate-90" :icon="['fas', 'phone']" ></font-awesome-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div>
                        <div class="w-1/3 text-center mb-2">
                            <div class="mx-auto w-20 h-20 cursor-pointer bg-gray-400 hover:bg-gray-500 rounded rounded-full flex items-center justify-center font-bold text-xl text-purple-800">
                                <div>
                                    <font-awesome-icon icon="phone" class="transform rotate-90"></font-awesome-icon>
                                </div>
                            </div>
                        </div>    
                    </div>        
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {
        Relay
    } from '@signalwire/js'
    import axios from 'axios';
    export default {
        props: ['id'],
        async mounted() {
            var resData = {
                "expires_in": 10000,
                "resource": this.id
            };
            let {
                data
            } = await axios.post('/api/relay/test', resData)
            this.client = new Relay({
                project: data.project_id,
                token: data.jwt_token
            })
            this.client.remoteElement = 'remoteAudio';
            this.client.iceServers = [{
                urls: ['stun:stun.l.google.com:19302']
            }];
            this.client.on('signalwire.notification', this.handleNotification);
            this.client.enableMicrophone();
            this.client.connect();
            window.addEventListener('keyup', this.keydown)
        },
        data() {
            return {
                showCallRecievingDialog: false,
                muted: false,
                minutess: 0,
                secondss: 0,
                timer: '',
                client: null,
                currentCall: null,
                phoneNumber: '',
                callStatus: 'idle',
                options: [{
                        text: 'available',
                        value: 'available'
                    },
                    {
                        text: 'idle',
                        value: 'idle'
                    }
                ]
            }
        },
        methods: {
            zeroPad(num, places) {
                var zero = places - num.toString().length + 1;
                return Array(+(zero > 0 && zero)).join("0") + num;
            },
            unhold() {
                this.currentCall.unhold();
            },
            hold() {
                clearInterval(this.timer);
                this.currentCall.hold()
            },
            disconnect() {
                this.currentCall.hangup()
                this.secondss = 0;
                this.minutess = 0;
                clearInterval(this.timer);
            },
            mute() {
                this.muted = !this.muted;
                this.currentCall.toggleAudioMute()
            },
            keydown(key) {
                if (['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '+'].includes(key.key)) {
                    this.phoneNumber = this.phoneNumber + key.key
                } else if (key.key == 'Backspace') {
                    this.backspace();
                }
            },
            call() {
                const params = {
                    destinationNumber: this.phoneNumber
                };

                this.currentCall = this.client.newCall(params);
            },
            push(number) {
                this.phoneNumber = this.phoneNumber + number;
            },
            backspace() {
                this.phoneNumber = this.phoneNumber.slice(0, -1);
            },
            answer() {
                this.showCallRecievingDialog = false;
                this.currentCall.answer();
            },
            dismiss() {
                this.phoneNumber = null;
                this.callStatus = 'idle';
                this.currentCall.hangup();
                this.showCallRecievingDialog = false;
            },
            handleNotification(notification) {
                switch (notification.type) {
                    case 'callUpdate':
                        this.handleCallUpdate(notification.call);
                        break;
                    case 'userMediaError':
                        // Permission denied or invalid audio/video params on `getUserMedia`
                        break;
                }
            },
            runTimer() {
                if(this.secondss == 59) {
                    this.secondss = 0;
                    this.minutess++;
                } else {
                    this.secondss++;
                }
            },
            handleCallUpdate(call) {
                this.currentCall = call;
                console.log(call);

                switch (call.state) {
                    case 'new': // Setup the UI
                        break;
                    case 'trying': // You are trying to call someone and he's ringing now
                        this.callStatus = 'Calling';
                        break;
                    case 'recovering': // Call is recovering from a previous session
                        if (confirm('Recover the previous call?')) {
                            this.currentCall.answer();
                        } else {
                            this.currentCall.hangup();
                        }
                        this.callStatus = 'Recovering';
                        break;
                    case 'ringing': // Someone is calling you
                        this.phoneNumber = this.currentCall.options.remoteCallerNumber;
                        this.callStatus = 'Ringing';
                        this.showCallRecievingDialog = true;
                        break;
                    case 'active': // Call has become active
                        this.callStatus = 'On Call';
                        let vm = this;
                        this.timer = setInterval(vm.runTimer, 1000);
                        break;
                    case 'hangup': // Call is over
                        this.callStatus = 'hangup';
                        this.phoneNumber = '';
                        this.showCallRecievingDialog = false;
                        break;
                    case 'destroy': // Call has been destroyed
                        this.callStatus = 'idle';
                        this.phoneNumber = '';
                        this.showCallRecievingDialog = false;
                        break;
                    case 'held': 
                        this.callStatus = 'held';
                        break;
                }
            }
        }
    }

</script>
