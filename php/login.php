<?php
include_once("connect.php");
    // Check if the username and password fields are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Check if the user is in the database
        $query = "SELECT * FROM user WHERE username = :username";
        $statement = $conn->prepare($query);
        $statement->bindValue(':username', $_POST['username']);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();
        // If the user is in the database, check if the password is correct
        if ($user != false) {
            if (password_verify($_POST['password'], $user['password'])) {
                // Start a session
                session_start();
                // Set the session variables
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                // Redirect to the home page
                header("Location: index.php");
            } else {
                echo "Incorrect password";
            } //user already exist weg gehaald voor onnodige melding//
        }
    }
    ?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>Comic Library</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">

    <link href="/docs/5.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.2/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.2/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.2/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
    <style type="text/css">
        @font-face {
            font-family: Roboto;
            src: url("chrome-extension://mcgbeeipkmelnpldkobichboakdfaeon/css/Roboto-Regular.ttf");
        }
    </style>
</head>

<body class="text-center" cz-shortcut-listen="true">

    <main class="form-signin w-100 m-auto">
        <form method="POST" action="">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" placeholder="name" name="username" id="username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-danger" type="submit">Sign in</button>
            <p class="text-center">Are you new? Register <a href="register.php">here!</a></p>
            <p class="mt-5 mb-3 text-muted">© 2017–2022</p>
        </form>
    </main>





    <script>
        var returnedSuggestion = ''
        let editor, doc, cursor, line, pos
        document.addEventListener("keydown", (event) => {
            setTimeout(() => {
                editor = event.target.closest('.CodeMirror');
                if (editor) {
                    doc = editor.CodeMirror.getDoc()
                    cursor = doc.getCursor()
                    line = doc.getLine(cursor.line)
                    pos = {
                        line: cursor.line,
                        ch: line.length
                    }
                    if (event.key == "Enter") {
                        var query = doc.getRange({
                            line: Math.max(0, cursor.line - 10),
                            ch: 0
                        }, {
                            line: cursor.line,
                            ch: 0
                        })
                        window.postMessage({
                            source: 'getSuggestion',
                            payload: {
                                data: query
                            }
                        })
                        //displayGrey(query)
                    } else if (event.key == "ArrowRight") {
                        acceptTab(returnedSuggestion)
                    }
                }
            }, 0)
        })

        function acceptTab(text) {
            if (suggestionDisplayed) {
                doc.replaceRange(text, pos)
                suggestionDisplayed = false
            }
        }

        function displayGrey(text) {
            var element = document.createElement('span')
            element.innerText = text
            element.style = 'color:grey'
            var lineIndex = pos.line;
            editor.getElementsByClassName('CodeMirror-line')[lineIndex].appendChild(element)
            suggestionDisplayed = true
        }
        window.addEventListener('message', (event) => {
            if (event.source !== window) return
            if (event.data.source == 'return') {
                returnedSuggestion = event.data.payload.data
                displayGrey(event.data.payload.data)
            }
        })
    </script>
</body>

</html>



</body>

</html>
<!-- needed for commit! -->