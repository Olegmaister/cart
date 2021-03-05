// 4 functions - url manager
function checkUrlByName(url, key) {
    if (!url || !key) {
        alert('error function 1')
    }

    let fullKey = key + '=';

    if (url.indexOf('?' + fullKey) !== -1) {
        fullKey = '\\?' + fullKey;
    } else if (url.indexOf('&' + fullKey) !== -1) {
        fullKey = '&' + fullKey;
    }

    let regEx = new RegExp(fullKey + '[\\w,-]+');
    return result = url.match(regEx);
}

function checkAndReplaceUrlValue(returnValue, key, $value) {
    let split = returnValue[0].split('=');
    let arr = split[1].split(',');
    let flag = false;

    arr.forEach(function (item, i, arr) {
        if (item == $value) {
            flag = true;
            //break;
        }
    });

    if (!flag) {
        arr.push($value)
    }
    return split[0] + '=' + arr.toString();
}

function prepareUrl(key, value, currentSearch, url) {
    var newUrl = url;
    if (currentSearch == '') {
        if (value != '') {
            newUrl += '?' + key + '=' + value;
        }

    } else if (currentSearch.indexOf('&') === -1 && currentSearch.indexOf(key) === -1) {
        if (value != '') {
            newUrl += currentSearch + '&' + key + '=' + value;
        }

    } else if (key != '' && currentSearch.indexOf(key + '=') === -1) {
        newUrl += currentSearch + '&' + key + '=' + value;

    } else {
        var returnValue = checkUrlByName(currentSearch, key);

        if (value == '' && returnValue) {
            newUrl += currentSearch.replace(returnValue, '');
        } else {
            if (key == 'sort' || key == 'price_min' || key == 'price_max') {
                let split = returnValue[0].split('=');
                var newKeyValue = split[0] + '=' + value;
            } else {
                var newKeyValue = checkAndReplaceUrlValue(returnValue, key, value);
            }
            newUrl += currentSearch.replace(returnValue, newKeyValue);
        }
    }

    if (newUrl.indexOf(url + '&') !== -1) {
        newUrl = newUrl.replace(url + '&', url + '?');
    }

    return newUrl;
}

function checkAndChangeUrl(key, value = '', remove = null) {
    let currentSearch = location.search;
    let pathname = location.pathname;

    if (remove) {
        let regEx = new RegExp(key + '=' + '[\\w,-]+');
        let data = currentSearch.match(regEx);
        let arr = data[0].split('=');
        let splitData = arr[1].split(',');
        var j = 0;
        var newValue = [];

        splitData.forEach(function (item, i, arr) {
            if (item != value) {
                newValue[j] = item;
                j++;
            }
        });

        newValue = newValue.toString();
        if (newValue == '') {
            var newUrl = prepareUrl(key, '', currentSearch, pathname);
        } else {
            var newUrl = pathname + currentSearch.replace(data[0], key + '=' + newValue);
        }
    } else {

        var newUrl = prepareUrl(key, value, currentSearch, pathname);
    }

    history.pushState(null, '', newUrl);
    if (location.search) {
        addClearPanel();
    } else {
        removeClearPanel();
    }
}