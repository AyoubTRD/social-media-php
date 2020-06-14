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
    methods: {
        async switchChat(id) {
            this.message = "";
            this.messages = [];
            this.showMessages = true
            this.currentUser = this.users.find(user => user.id === id);
            this.loadingMessages = true;
            const res = await fetch("/endpoints/messages.php?user_id=" + this.currentUser.id)
            const data = await res.json();
            this.messages = data.data;
            this.loadingMessages = false;
            this.title = this.currentUser.name
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
                content: this.message
            })
            this.message = "";
        },
        scrollToBottom() {
            const messagesContainer = document.querySelector(".messages-users-container")
            messagesContainer.scroll(0, messagesContainer.clientHeight + 1000)
        }
    },
    async created() {
        const res = await fetch("/endpoints/users.php");
        const data = await res.json();
        this.users = data.data;

        socket.on("message", async (message) => {
            if (this.currentUser && message.user_from === this.currentUser.id) {
                this.messages.push(message);
                await fetch("/endpoints/messages.php?no_fetch=true&user_id=" + this.currentUser.id);
            }
        })

        socket.on("online_user", ({id}) => {
            const user = this.users.find(u => u.id === id);
            user.is_online = 1;
            console.log(this.users)
        })
        socket.on("offline_user", ({id}) => {
            const user = this.users.find(u => u.id === id);
            user.is_online = 0;
            console.log(this.users)
        })
    },
    updated() {
        if (!this.showMessages) return
        this.scrollToBottom()
    }
})
console.log("Hello world")