$(document).ready(function(){
  // Auteosize Plugin
  autosize($('textarea'));

  $('[data-trigger="confirm"]').click(function() {
    if (!confirm("Are you sure you want to proceed?")) {
      return false;
    }
  });

  $('[data-trigger="post-like"]').click(function(event) {
    var $this = this;
    const href = $($this).data('href');
    const post = $($this).data('post');
    const user = $($this).data('user');


    $.ajax({
      contentType: 'application/json',
      data: JSON.stringify({
        'post_id': post,
        'user_id': user,
      }),
      type: 'POST',
      url: href,
      success: function() {
        $($this).hide();
        $($this).siblings('[data-trigger="post-unlike"]').show();
        $('[data-post="' + post + '"].like-count').text(function(index, text) {
          $(this).html(parseInt(text) + 1);
        });
      },
    });

    event.preventDefault();
  });

  $('[data-trigger="post-unlike"]').click(function(event) {
    var $this = this;
    const href = $($this).data('href');
    const post = $($this).data('post');
    const user = $($this).data('user');

    $.ajax({
      contentType: 'application/json',
      data: JSON.stringify({
        'post_id': post,
        'user_id': user,
      }),
      type: 'DELETE',
      url: href,
      success: function() {
        $($this).hide();
        $($this).siblings('[data-trigger="post-like"]').show();
        $('[data-post="' + post + '"].like-count').text(function(index, text) {
          $(this).html(parseInt(text) - 1);
        });
      },
    });

    event.preventDefault();
  });
});