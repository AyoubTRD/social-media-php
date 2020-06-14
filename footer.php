
    <?php if (!isset($no_container)) { echo "</div>"; } ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    <script type="text/javascript" src="<?php echo $website_base.'/assets/js/index.js' ?>"></script>
<!--    <footer class="py-10 bg-gray-800">-->
<!--      <div class="ui container">-->
<!--        <p class="text-white">-->
<!--          TRD Social Media 2020 &copy; <br>-->
<!--          Developed by <a href="https://ayoubtaouarda.netlify.com/" target="_blank" class="text-blue-400 hover:text-blue-500">Ayoub Taouarda</a>-->
<!--        </p>-->
<!--      </div>-->
<!--    </footer>-->
    <?php if ($is_logged_in) {
      include_once $_SERVER["DOCUMENT_ROOT"]."/components/chat.php";
    } ?>
  </body>
</html>
