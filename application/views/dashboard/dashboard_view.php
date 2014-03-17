<div id="board" class="row">

	<!--Tweetboard-->
    <div id="tweetboard-main" class="col-md-5">
        <h3>Tweetboard</h3>
        <div class="form-horizontal">
          <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control input_query" name="query" id="query" placeholder="New Query Term...">
            </div>
            <div class="col-md-8">
                <button id="submit" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Search</button>
                <a class="btn btn-info btn-sm" id="login"><i class="fa fa-twitter"></i> Login with Twitter</a>
            </div>
          </div>
        </div>

        <hr>


        <div class="tweets col-md-10 col-md-offset-1">

        <!--
        <blockquote class="twitter-tweet"><p>GRAB <a href="https://twitter.com/search?q=%23skate&amp;src=hash">#skate</a> <a href="https://twitter.com/search?q=%23skateboard&amp;src=hash">#skateboard</a> <a href="https://twitter.com/search?q=%23skateboarding&amp;src=hash">#skateboarding</a> <a href="http://t.co/RuyaivWiOB">pic.twitter.com/RuyaivWiOB</a></p>&mdash; Skate (@SKATE) <a href="https://twitter.com/SKATE/statuses/392351081310609409">October 21, 2013</a></blockquote>
        <blockquote class="twitter-tweet"><p>GRAB <a href="https://twitter.com/search?q=%23skate&amp;src=hash">#skate</a> <a href="https://twitter.com/search?q=%23skateboard&amp;src=hash">#skateboard</a> <a href="https://twitter.com/search?q=%23skateboarding&amp;src=hash">#skateboarding</a> <a href="http://t.co/RuyaivWiOB">pic.twitter.com/RuyaivWiOB</a></p>&mdash; Skate (@SKATE) <a href="https://twitter.com/SKATE/statuses/392351081310609409">October 21, 2013</a></blockquote>

        <blockquote class="twitter-tweet"><a href="https://twitter.com/twitterapi/status/443058232240914400"></a></blockquote>
        <blockquote class="twitter-tweet"><a href="https://twitter.com/twitterapi/status/443058221889384450"></a></blockquote>
        <blockquote class="twitter-tweet"><a href="https://twitter.com/twitterapi/status/443058206735339500"></a></blockquote>
        <blockquote class="twitter-tweet"><a href="https://twitter.com/twitterapi/status/443058205841981440"></a></blockquote>
        <blockquote class="twitter-tweet"><a href="https://twitter.com/twitterapi/status/443058202880802800"></a></blockquote>
        <blockquote class="twitter-tweet"><a href="https://twitter.com/twitterapi/status/443058201404010500"></a></blockquote>
        -->
        </div>
	</div>

    <!--Dashboard-->
	<div id="dashboard-main" class="col-md-6 col-md-offset-1">
        
        <!--To-Do-->
        <h3>To-Do</h3>
        <form id="create_todo" class="form-horizontal" method="post" action="<?=site_url('api/create_todo')?>">
            <div class="input-append">
                <div class="row">
                    <div class="col-md-8">
            	       <input type="text" name="content" class="input_todo col-md-12" placeholder="New Todo Item" />
                    </div>
                    <div class="col-md-4">
            	       <input type="submit" class="btn btn-success btn-sm" value="Create" />
                    </div>
                </div>
        	</div>
        </form>
        <div class="row">        
            <div id="list_todo">
        	   <span class="ajax-loader-gray"></span>
            </div>
        </div>
        <hr>

        <!--Note-->
        <h3>Note</h3>
		<form id="create_note" class="form-horizontal" method="post" action="<?=site_url('api/create_note')?>">
            <div class="input-append">
                <div class="row">
                    <div class="col-md-8">
            	       <input type="text" name="title" class="input_note_title col-md-12" placeholder="New Note Title" />
                    </div>
                    <div class="col-md-4">
            	       <input type="submit" class="btn btn-success btn-sm" value="Create" />
                    </div>
                </div>
        	</div>

            <div class="row">
                <div class="col-md-8">
                	<div class="clearfix"></div>
                	<textarea name="content" class="input_note_content col-md-12" placeholder="New Note Content"></textarea>
                </div>
            </div>      	
        </form>
        <div class="row">
            <div id="list_note">
        	   <span class="ajax-loader-gray"></span>
            </div>
        </div>
	</div>
</div>


<!--JAVASCRIPTs-->
<script type='text/javascript'
        src='https://cdn.firebase.com/js/simple-login/1.3.0/firebase-simple-login.js'>
</script>
<script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script type="text/javascript">
    /*Terry's update*/ 
    /*for post token and secret to api*/
        function post_to_url(path, params, method) {
            method = method || "post"; // Set method to post by default, if not specified.

            // The rest of this code assumes you are not using a library.
            // It can be made less wordy if you use one.
            var form = document.createElement("form");
            form.setAttribute("method", method);
            form.setAttribute("action", path);

            for(var key in params) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);
                form.appendChild(hiddenField);
            }
            form.submit(function (e) {

            });
        }
</script>
<script type="text/javascript">
        /*Terry's update, login via firebase*/ 
        $('#login').click(function(){
            var chatRef = new Firebase('https://popping-fire-6350.firebaseio.com');
            var auth = new FirebaseSimpleLogin(chatRef, function(error, user) {

              if (error) {
                // an error occurred while attempting login
                alert(error);
              } else if (user) {
                // user authenticated with Firebase

                alert('User ID: ' + user.id + ', Provider: ' + user.provider + 'token:' + user.accessToken + 'secret:' + user.accessTokenSecret);
                post_to_url('/Sqrrel/index.php/api/twitterOath', {'token':user.accessToken,'secret':user.accessTokenSecret});
              } else {
                // user is logged out
              }
            });
            auth.login('twitter');
        });
</script>
<script>
        /*Terry's update, to send query and parse return json and render into tweets*/ 
      $('#submit').click(function() {
        $('.tweets').html('');
        var searchVal = $('#query').val();
//            alert('yes!');
          if(searchVal !== '') {
              $.get('api/getTweets?query='+searchVal, function(returnData) {
                  /* If the returnData is empty then display message to user
                   * else our returned data results in the table.  */
                   alert(returnData);
                  var obj = $.parseJSON(returnData);

                  /*no return data*/
                  if (obj.length === 0) {
                    alert('return 0 data');
                  } else {
                    obj.forEach(function(entry) {
                        $('.tweets').append(entry);      
                    });
                  }
              });
            }
      });
</script>
