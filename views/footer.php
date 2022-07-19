 </div>
 <script>
     function deleteName(evt) {
         if (confirm("Вы уверены, что хотите удалить запись?")) {
             evt.preventDefault();
         } else {
             evt.submit();
         }
     }
 </script>
 </body>

 </html>