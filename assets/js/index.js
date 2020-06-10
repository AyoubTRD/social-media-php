$('.ui.dropdown').dropdown();
for (let form of document.querySelectorAll("form.submit-on-click")) {
  form.onclick = () => {
    form.submit();
  }
}

for (let likeBtn of document.querySelectorAll(".post-like")) {
  likeBtn.onclick = () => {
    const is_liked = likeBtn.classList.contains("active");
    const postID = likeBtn.getAttribute("data-post-id");
    fetch("/api/like.php?post_id=" + postID);
    likeBtn.classList.toggle("active");
    const likeCount = likeBtn.querySelector(".likes-count");
    const oldCount = parseInt(likeCount.textContent);

    let newCount
    if (is_liked) {
      newCount = oldCount - 1;
    } else {
      newCount = oldCount + 1;
    }
    likeCount.textContent = newCount.toString();
  }
}

for (let likeBtn of document.querySelectorAll(".comment-like")) {
  likeBtn.onclick = () => {
    const is_liked = likeBtn.classList.contains("active");
    const commentID = likeBtn.getAttribute("data-comment-id");
    fetch("/api/like.php?comment_id=" + commentID);
    likeBtn.classList.toggle("active");
    const likeCount = likeBtn.querySelector(".likes-count");
    const oldCount = parseInt(likeCount.textContent);

    let newCount
    if (is_liked) {
      newCount = oldCount - 1;
    } else {
      newCount = oldCount + 1;
    }
    likeCount.textContent = newCount.toString();
  }
}
