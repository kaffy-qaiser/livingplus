<script>
    document.querySelectorAll('.slider').forEach(function(slider) {
        slider.oninput = function() {
            document.getElementById(slider.id + 'Value').innerText = slider.value;
        };
    });
</script>
<script>
    function updateWordCount() {
        var textarea = document.getElementById('reviewTextArea');
        var wordCount = 0;
        var words = textarea.value.match(/\b[-?(\w+)?]+\b/gi);
        if (words) {
            wordCount = words.length;
            if (wordCount > 100) {
                textarea.value = words.slice(0, 100).join(' ');
                wordCount = 100;
            }
        }
        document.getElementById('wordCount').innerText = wordCount;
    }
</script>