const socket = io(NODE_SERVER, {
    query: "id=" + ID
});

new Vue({
    el: "#chat",
    data: {
        showChat: false,
        users: [],
        showMessages: false,
        messages: [],
        currentUser: null,
        title: "Users",
        loadingMessages: false,
        message: ""
    },
    computed: {
        unreadDiscussions() {
            if (!this.users) return 0
            return this.users.reduce((acc, user) => acc + Math.min(user.unseen_messages, 1), 0)
        }
    },
    methods: {
        async switchChat(id) {
            this.message = "";
            this.messages = [];
            this.showMessages = true
            this.currentUser = this.users.find(user => user.id === id);
            this.currentUser.unseen_messages = 0;
            this.loadingMessages = true;
            const res = await fetch("/endpoints/messages.php?user_id=" + this.currentUser.id)
            const data = await res.json();
            this.messages = data.data;
            this.loadingMessages = false;
            this.title = this.currentUser.name
            if (!this.messages.length) return
            const lastMessage = this.messages[this.messages.length - 1];
            socket.emit("see_message", {
                ...lastMessage,
                user_to: ID
            })
        },
        back() {
            this.showMessages = false;
            this.currentUser = null;
            this.title = "Users";
            this.message = "";
            this.messages = [];
        },
        handleMessageFormSubmit() {
            if(!this.message) return
            this.message = this.message.trim();
            socket.emit("send_message", {
                to: this.currentUser.id,
                content: this.message
            })
            this.messages.push({
                user_from: ID,
                user_to: this.currentUser.id,
                content: this.message,
                created_at: new Date()
            })
            const user = this.users.find(u => u.id === this.currentUser.id);
            user.last_message_content = this.message;
            this.message = "";
        },
        scrollToBottom() {
            const messagesContainer = document.querySelector(".messages-users-container")
            messagesContainer.scroll(0, messagesContainer.scrollHeight)
        },
        async fetchUsers() {
            const res = await fetch("/endpoints/users.php?messages=true");
            const data = await res.json();
            this.users = data.data.map(user => ({...user, unseen_messages: parseInt(user.unseen_messages)}));
        },
        shorten(str, num) {
            if (!str) return ""
            if (str.length < num - 3) return str
            return str.slice(0, num - 3) + "...";
        },
        messageFormatDate(str) {
            if (!str) return ""
            const date = new Date(str);
            const h = date.getHours();
            const m = date.getMinutes();
            const hh = h < 10 ? '0' + h : h;
            const mm = m < 10 ? '0' + m : m;
            return `${hh}:${mm}`;
        }
    },
    async created() {
        this.fetchUsers()
        socket.on("message", async (message) => {
            message.created_at = message.created_at || new Date();
            const user = this.users.find(u => u.id === message.user_from);
            user.last_message_content = message.content;
            if (this.currentUser && message.user_from === this.currentUser.id) {
                this.messages.push(message);
                await fetch("/endpoints/messages.php?no_fetch=true&user_id=" + this.currentUser.id);
                socket.emit("see_message", {
                    ...message,
                    user_to: ID
                })
                await fetch("/endpoints/messages.php?no_fetch=true&user_id=" + this.currentUser.id)
            } else {
                user.unseen_messages++
            }
        })

        socket.on("message_seen", (message) => {
            if (this.currentUser && !message.user_to === this.currentUser.id) return
            const newMsgs = [...this.messages];
            newMsgs[newMsgs.length - 1].seen = 1;
            this.messages = newMsgs
        })

        socket.on("online_user", ({id}) => {
            const user = this.users.find(u => u.id === id);
            user.is_online = 1;
        })
        socket.on("offline_user", ({id}) => {
            const user = this.users.find(u => u.id === id);
            user.is_online = 0;
        })
    },
    updated() {
        if (!this.showMessages) return
        this.scrollToBottom()
    }
})
