</div>
<script>
    let buttonsDelete = document.querySelectorAll('.delete-btn');
    buttonsDelete.forEach(buttonsDelete => {
        buttonsDelete.addEventListener('click', (evt) => {
            let result = confirm('Вы уверены?');
            if (!result) {
                evt.preventDefault();
            }
        })
    })
</script>
</body>

</html>