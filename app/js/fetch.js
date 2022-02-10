/*global fetch*/

function object2query(obj) {
  let q = '';
  for(const prop in obj) {
    if(q.length > 0) q += '&';
    q += prop + '=' + obj[prop];
  }
  return q;
}

async function fetchJSON(requestURL, getQuery = {}, postQuery = {}, $isFileMode = false) {
  const useGet = Object.keys(getQuery).length, usePost = Object.keys(postQuery).length;

// リクエストデータ
  const data = {
    method: usePost ? 'POST' : 'GET',
    headers: {'Content-Type': $isFileMode ? 'multipart/form-data' : usePost ? 'application/x-www-form-urlencoded' : 'text/plain'},
    mode: 'cors',
    cache: 'no-cache',
    credentials: 'same-origin',
    redirect: 'follow',
    referrerPolicy: 'no-referrer'
  };
  if(usePost) data.body = object2query(postQuery);

  const response = await fetch(requestURL + (useGet ? '?' + object2query(getQuery) : ''), data);
  return response.json();
}