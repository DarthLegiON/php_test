<html>
<header>
    <title>js</title>
    <script src="main.js"></script>
    <link rel="stylesheet" type="text/css" href="main.css">

</header>
<body>
<form action="" id="test-form">
    <div class="validate-block">
        <label for="letters">letters</label>
        <input type="letters" id="letters">
    </div>
    <div class="validate-block">
        <label for="numbers">numbers</label>
        <input type="numbers" id="numbers">
    </div>

    <div class="validate-block">
        <span>Format: (xxx) xxx-xx-xx</span></br>
        <label for="phone">phone</label>
        <input type="phone" id="phone">
    </div>
    <div class="validate-block">
        <label for="email">email</label>
        <input type="email" id="email">
    </div>
    <button id="validate-button">Validate</button>
</form>
</body>
</html>
