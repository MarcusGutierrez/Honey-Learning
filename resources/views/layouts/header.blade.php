<script language="JavaScript">
    //Prevents use of back button
    //Found at https://gist.github.com/w33tmaricich/7009931 on 12/20/2017
    window.onload = function () {
    if (typeof history.pushState === "function") {
        history.pushState("jibberish", null, null);
        window.onpopstate = function () {
            history.pushState('newjibberish', null, null);
            // Handle the back (or forward) buttons here
            // Will NOT handle refresh, use onbeforeunload for this.
        };
    }

    else {
        var ignoreHashChange = true;
        window.onhashchange = function () {
            if (!ignoreHashChange) {
                ignoreHashChange = true;
                window.location.hash = Math.random();
                // Detect and redirect change here
                // Works in older FF and IE9
                // * it does mess with your hash symbol (anchor?) pound sign
                // delimiter on the end of the URL
            }
            else {
                ignoreHashChange = false;   
            }
        };
    }

}   
</script>


<div class="card text-center" style="position: relative;">
  
    <div class="card-footer text-muted">
        <h2>Honeypot Intrusion</h2>
    </div>
</div>