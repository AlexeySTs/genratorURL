<?php
    return '<div class="testbox">
            <h1>Генератор коротких УРЛ</h1>
                <form method="POST" action="/geturl">
                <label class="label_form"> Введите URL
                    <input class="form_url" type="text" name="url">
                </label>
                <br>
                <label id = "submit"> 
                    <input class="submit_button" type="submit">
                </label>
                <br>
                <label > Сгенерированный URL
                <input disabled class="result" id = "result"></input>
                </label>
                </form>
            <script src="/script.js"></script>
                
            </div>';
            
?>