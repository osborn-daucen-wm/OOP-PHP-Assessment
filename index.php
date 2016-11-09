<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" href="styles.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <title>Final Blog</title>
</head>

<body>

<div id="main">
    <div id="postsContainer">
        <h1 style="margin-left: 5%">My Blog</h1>

        <div id="blogPosts">
            <h2 style="margin-left: 5%">Posts</h2>
            <hr />
            <?php
            include ("include.php");

            $blogPosts = GetBlogPosts();
            $database = new Databases();


            if(@$_POST['submit']){
                $title = $_POST['title'];
                $body = $_POST['body'];
                $author_id = $_POST['author_id'];
                $date_posted = $_POST['date_posted'];

                $database->query('INSERT INTO blog_posts (title, post, author_id, date_posted) VALUES (:title, :post, :author_id, :date_posted)');
                $database->bind(':title', $title);
                $database->bind(':post', $body);
                $database->bind(':author_id', $author_id);
                $database->bind(':date_posted', $date_posted);
                $database->execute();


                if($database->lastInsertId()){
                    echo "<p>Post Added!</p>";
                }

                echo "<meta http-equiv='refresh' content='0'>";
            }

            if(@$_POST['delete']){
                $delete_id = $_POST['delete_id'];
                $database->query('DELETE FROM blog_posts WHERE id = :id');
                $database->bind(':id', $delete_id);
                $database->execute();

                echo "<meta http-equiv='refresh' content='0'>";
            }

            foreach ($blogPosts as $post)
            {
                echo "<div class='post'>";
                echo "<h2>" . $post->title . "</h2>";
                echo "<p>" . $post->post . "</p>";
                echo "<span class='footer'>Posted By: " . $post->author . "<br />" . " Posted On: " . $post->datePosted . "<br />" . " Tags: " . $post->tags . "</span>";
                echo "<form method=\"post\"><input type=\"hidden\" name=\"delete_id\" value=\"" . $post->id . "\">" . "<input type=\"submit\" class=\"btn\" name=\"delete\" value=\"Delete\"/></form>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <div id="newPostContainer">
        <div id="newPost">
            <h1>Add Posts</h1>
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                <label>Post Title</label><br />
                <input type="text" name="title" class=\"input_text\" placeholder="Add a Title..." /><br /><br />
                <label>Post Body</label><br />
                <textarea name="body" class=\"input_text\" placeholder="Add blog text..."></textarea><br /><br />
                <label>Post Author id</label><br />
                <input type="text" name="author_id" class=\"input_text\" placeholder="Add an id..."/><br /><br />
                <input type="hidden" name="date_posted" value="<?php print (date("Y-m-d")); ?>">
                <input type="submit" name="submit" class="" style="" value="Submit"/>
            </form>
        </div>
    </div>
</div>

</body>

</html>