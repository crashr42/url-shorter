(function (window) {
    var ajax = function (url, done, fail) {
        var executor = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("MicrosoftXMLHTTP");
        executor.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    done(this.responseText);
                } else {
                    fail(this.responseText);
                }
            }
        };
        executor.open("get", url, true);
        executor.send();

    };

    window.onload = function () {
        var page = (function () {
            return {
                result: window.document.querySelector('#result'),
                long_url: window.document.querySelector('input[name=long_url]'),
                form: window.document.querySelector('#long-url-from')
            };
        })();

        page.form.onsubmit = function () {
            var action = page.form.getAttribute('action');
            var url = action + '?long_url=' + encodeURIComponent(decodeURIComponent(page.long_url.value));

            ajax(url, function (response) {
                var obj = JSON.parse(response);

                var shortA = document.createElement("a");
                shortA.href = obj.url;
                shortA.text = obj.url;
                shortA.setAttribute('target', '_blank');

                page.result.innerHTML = '';
                page.result.appendChild(shortA);
            }, function () {
                alert('Url invalid!');
            });

            return false;
        };
    };
})(window);
