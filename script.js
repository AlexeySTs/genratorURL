

let form = document.querySelector('form');

form.addEventListener('submit', function (event) {
    
    // Значение URL с обрезанными пробелами по краям
    url = document.querySelector('.form_url').value.trim(); 
    
    // Проверка на пробелы у URL
    if(url.indexOf(' ', 0) !== -1 || url == '') { 

        // Делаем временный див с ошибкой
        
        let div = document.createElement('div');
        let content = document.querySelector('.label_form')
        div.innerHTML = 'URL содержит пробелы';
        div.classList.add('error_url');
        content.appendChild(div);
        setTimeout(()=>{
            div.remove()
            }, 1000);
            
        event.preventDefault()
        
        return
    }
    
    // AJAX Запрос
	let promise = fetch('/geturl', {
		method: 'POST',
		body: new FormData(this),
	}).then(
		response => {
			return response.text();
		}
	).then(
		text => {
		    console.log(text);
		    document.querySelector('#result').value = text;
			
		}
	);
	
	event.preventDefault();
}); 
