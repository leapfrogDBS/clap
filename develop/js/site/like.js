// like button
const likeBtn = document.querySelectorAll(".like-btn");
const likeBtnIcon = document.querySelectorAll(".like-icon");
const likeBtnNum = document.querySelectorAll(".like-number");

// Load like state from local storage
likeBtn.forEach((item, index) => {
  const postId = likeBtn[index].closest('.slide').getAttribute('data-post-id');
  const isLiked = localStorage.getItem(`liked_post_${postId}`) === 'true';
  likeBtn[index].setAttribute('data-liked', isLiked);
  if (isLiked) {
    likeBtnIcon[index].classList.replace("fa-heart-o", "fa-heart");
  }
});

likeBtn.forEach((item, index) => {
  likeBtn[index].addEventListener("click", function () {
    // Get current like number
    let likeNum = parseInt(likeBtnNum[index].innerText);

    // Get the current liked state
    let isLiked = likeBtn[index].getAttribute("data-liked") === "true";

    // Toggle the like state
    if (isLiked) {
      unLikePost(index, likeNum);
    } else {
      likePost(index, likeNum);
    }

    // Update the liked state attribute
    likeBtn[index].setAttribute("data-liked", !isLiked);

    // Save the like state to local storage
    const postId = likeBtn[index].closest('.slide').getAttribute('data-post-id');
    localStorage.setItem(`liked_post_${postId}`, !isLiked);

    // Send AJAX request to update the like count in the backend
    if (!isLiked) {
      jQuery.ajax({
        type: 'POST',
        url: ajax_object.ajax_url,
        data: {
          action: 'like_post',
          post_id: postId,
          nonce: ajax_object.nonce
        },
        success: function(response) {
          if (response.success) {
            likeBtnNum[index].innerText = response.data.new_likes;
          }
        }
      });
    }
  });
});

function likePost(index, likeNum) {
  likeBtnIcon[index].classList.replace("fa-heart-o", "fa-heart");
  likeBtnNum[index].innerText = likeNum + 1;
}

function unLikePost(index, likeNum) {
  likeBtnIcon[index].classList.replace("fa-heart", "fa-heart-o");
  likeBtnNum[index].innerText = likeNum - 1;
}
