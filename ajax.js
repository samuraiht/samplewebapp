async function fetchJSON(requestURL, getQuery = '', postQuery = '') {
  const data = {
    method: postQuery != '' ? 'POST' : 'GET',
    headers: {'Content-Type': postQuery != '' ? 'application/x-www-form-urlencoded' : 'text/plain'},
    mode: 'cors',
    cache: 'no-cache',
    credentials: 'same-origin',
    redirect: 'follow',
    referrerPolicy: 'no-referrer'
  };
  if(postQuery != '') data.body = postQuery;
  const response = await fetch(requestURL + (getQuery != '' ? '?' + getQuery : ''), data);
　return response.json();
}