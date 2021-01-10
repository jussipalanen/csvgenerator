
document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("csvgenerator_form");
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        var elements = form.elements;
        var data = new FormData();
        for (var index = 0; index < elements.length; index++) {
            var element = elements[index];
            if( element.name )
            {
                data.append(element.name, element.value);
            }

        }

        fetch("?ajax=1", {
            method: 'post',
            body: data
        }).then(function(response)
        {
            return response.json();
        }).then(function(response)
        {
            if( response.success )
            {
                var element = document.createElement('a');
                element.append(document.createTextNode("Download"));
                element.title = 'Download';
                element.href = response.data.link;
                element.setAttribute('download', '');
                document.getElementById('output').innerHTML = "";
                document.getElementById('output').appendChild(element);
                
            }
        });
    });
});


