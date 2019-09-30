<hr>
<h1>Error page</h1>

Sorry there were errors:

<p>
    <?= $message ?>

<p><button onclick="goBack()">Go Back</button></p>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</p>
<hr>