<template>
<div>
    <chat-window
    :current-user-id="currentUserId"
    :rooms="rooms"
    :messages="messages"
    :rooms-loaded="true"
    :messagesLoaded="messagesLoaded"
    @fetch-messages="fetchMessages"
    :show-add-room="false"
  />
</div>
</template>
<script>
import ChatWindow from 'vue-advanced-chat'
import 'vue-advanced-chat/dist/vue-advanced-chat.css'

export default {
    props: {
        id: {
            default: null,
            type: String
        }
    },
    components: {
        ChatWindow
    },
    async mounted() {
        let {data} = await axios.get('/api/user/sms_campaigns/'+this.id+'/conversations');
        this.conversations = data
        this.rooms = this.conversations.map((conversation,index) => {
            return {
                roomId: conversation.id,
                roomName: conversation.phone_number,
                avatar: '/img/people.png',
                unreadCount: 0,
                index: index + 1,
                userId: conversation.user_id,
                users: [
                    {
                        _id: 1234,
                        username: conversation.phone_number,
                        avatar: '/img/people.png',
                        status: {
                            state: false
                        }
                    },
                    {
                        _id: 4321,
                        username: 'John Snow',
                        avatar: '/img/people.png',
                        status: {
                        state: false
                        }
                    }
                ],
            }
        })
        this.currentUserId = this.rooms[0].userId
    },
    methods: {
        async fetchMessages(room) {
            this.messagesLoaded = false;
            let {data} = await axios.get('/api/user/sms_campaigns/'+this.id+'/conversations/'+room.room.roomId+'/messages')
            this.messages = data.data.map((message,index) => {
                this.currentUserId = message.user_id
                return {
                    _id: message.id,
                    content: message.text,
                    senderId: message.is_received?room.room.roomName: this.currentUserId,
                    username: message.is_received?room.room.roomName: 'You',
                    timestamp: '10:20' + index,
                    saved: true,
                    distributed: message.is_received,
                    seen: true,
                    new: false
                }
            })
            this.messagesLoaded = true;
        }
    },
    data() {
        return {
        conversations: [],
        messagesLoaded: false,
        rooms: [
            {
                roomId: 1,
                roomName: 'Room 1',
                avatar: '/img/people.png',
                unreadCount: 4,
                index: 3,
                lastMessage: {
                    content: 'Last message received',
                    senderId: 1234,
                    username: 'John Doe',
                    timestamp: '10:20',
                    saved: true,
                    distributed: false,
                    seen: false,
                    new: true
                },
                users: [
                {
                    _id: 1234,
                    username: 'John Doe',
                    avatar: '/img/people.png',
                    status: {
                    state: 'online',
                    lastChanged: 'today, 14:30'
                    }
                },
                {
                    _id: 4321,
                    username: 'John Snow',
                    avatar: '/img/people.png',
                    status: {
                    state: 'offline',
                    lastChanged: '14 July, 20:00'
                    }
                }
                ],
                typingUsers: [ 4321 ]
            }
        ],
        messages: [],
        currentUserId: 1234
        }
    }
}
</script>
