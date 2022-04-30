let meta_box_title = document.querySelector('#fbap_parser>div>h2').innerText;

let step_1 = document.querySelector('.submit-step-1');
let output = document.querySelector('.output');

step_1.addEventListener('click', function () {
    let step_1_url = document.querySelector('#parse_url').value;
    console.log(step_1_url);
    console.log(meta_box_title);

    let objXMLHttpRequest = new XMLHttpRequest();
    objXMLHttpRequest.onreadystatechange = function() {
        if(objXMLHttpRequest.readyState === 4) {
            if(objXMLHttpRequest.status === 200) {
                output.innerHTML = objXMLHttpRequest.responseText;
            } else {
                alert('Error Code: ' +  objXMLHttpRequest.status);
                alert('Error Message: ' + objXMLHttpRequest.statusText);
            }
        }
    }
    objXMLHttpRequest.open('POST', '../wp-content/plugins/fbpublisher/admin/parsers/parser_1.php');
    objXMLHttpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    objXMLHttpRequest.send('url=' + step_1_url);
});
