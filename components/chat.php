<script>
    const ID = "<?php echo $user['id'] ?>"
    const NODE_SERVER = "<?php echo $realtime_server ?>"
    const AUTH_USER = <?php echo json_encode($user) ?>;
</script>
<div id="chat">
  <button class="chat-btn w-24 h-24 rounded-full bg-blue-400 text-white text-3xl shadow-2xl" @click="showChat = !showChat">
    <i class="fa fa-comment"></i>
  </button>
  <div :class="`chat-card rounded-lg shadow-lg bg-white ${showChat ? '' : 'hide'}`">
    <div class="chat-card-header px-5 bg-blue-400 text-white rounded-lg rounded-b-none flex items-center justify-between h-16">
      <div class="flex items-center">
        <button v-if="showMessages" class="p-4 rounded-full border-none" @click="back">
          <i class="left arrow icon"></i>
        </button>
        <h3 class="inline-block ml-1 my-0">{{ title }}</h3>
      </div>
      <div v-if="showMessages" :class="`h-4 w-4 rounded-full ${currentUser.is_online == '1' ? 'bg-white' : 'bg-gray-400'}`"></div>
    </div>
    <div class="relative messages-users-container">
      <div :class="`chat-card-users ${showMessages ? 'slide' : ''}`">
        <div class="chat-card-user transition duration-300 bg-white hover:bg-gray-100 h-20 px-5 flex justify-between items-center cursor-pointer border-b border-blue-100" v-for="user in users" @click="switchChat(user.id)">
          <div class="flex items-center">
            <img :src="user.avatar" class="rounded-full w-12 h-12" alt="">
            <h5 class="ml-3 text-xl font-bold">{{ user.name }}</h5>
          </div>
          <p :class="`text-lg ${user.is_online == '1' ? 'text-blue-400' : 'text-gray-400'}`">{{ user.is_online == "1" ? "Online" : "Offline" }}</p>
        </div>
      </div>
      <div :class="`chat-card-messages flex flex-col justify-between px-3 mt-4 ${showMessages ? 'slide' : ''}`">
        <div class="chat-card-messages-container">
          <div :class="`chat-card-message flex mb-3 items-center ${message.user_from === ID ? 'own-message ml-auto justify-end' : 'external-message mr-auto justify-start'}`" v-for="message in messages">
            <img v-if="message.user_from !== ID" :src="currentUser.avatar" alt="" class="h-8 w-8 rounded-full">
            <p :class="`py-4 px-5 mx-3 mb-0 ${message.user_from === ID ? 'bg-blue-400 text-white' : 'bg-gray-200 '}`">{{ message.content }}</p>
            <img v-if="message.user_from === ID" :src="AUTH_USER.avatar" alt="" class="h-8 w-8 rounded-full">
          </div>
        </div>
        <div class="chat-card-message-form-container">
          <form class="w-full max-w-sm shadow-lg bg-gray-100 mx-auto" @submit.prevent="handleMessageFormSubmit">
            <div class="flex items-center border-b border-b-2 border-blue-400 py-1 pr-2">
              <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Send a message..." aria-label="message" v-model="message">
              <button class="flex-shrink-0 bg-blue-400 hover:bg-blue-500 text-md text-white h-12 w-12 rounded-full shadow-md" type="submit">
                <i class="paper plane icon"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js"></script>
<script src="/assets/js/chat.js"></script>
