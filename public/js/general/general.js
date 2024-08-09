function populatePagination(data, fetch) {
   
    const pagination = document.querySelector('.pagination');
    pagination.innerHTML = '';

    if (data.prev_page_url) {
        const prevItem = document.createElement('li');
        prevItem.classList.add('page-item');
        const prevLink = document.createElement('a');
        prevLink.classList.add('page-link');
        prevLink.href = '#';
        prevLink.innerText = 'Previous';
        prevLink.onclick = (event) => {
            event.preventDefault();
            // fetchAllItems(document.getElementById('search-input').value, data.current_page - 1);
            fetch(document.getElementById('search-input').value, data.current_page - 1);
        };
        prevItem.appendChild(prevLink);
        pagination.appendChild(prevItem);
    } else {
        const prevItem = document.createElement('li');
        prevItem.classList.add('page-item', 'disabled');
        const prevLink = document.createElement('a');
        prevLink.classList.add('page-link');
        prevLink.href = '#';
        prevLink.innerText = 'Previous';
        prevItem.appendChild(prevLink);
        pagination.appendChild(prevItem);
    }

    for (let page = 1; page <= data.last_page; page++) {
        const pageItem = document.createElement('li');
        pageItem.classList.add('page-item');
        if (page === data.current_page) {
            pageItem.classList.add('active');
        }
        const pageLink = document.createElement('a');
        pageLink.classList.add('page-link');
        pageLink.href = '#';
        pageLink.innerText = page;
        pageLink.onclick = (event) => {
            event.preventDefault();
            fetch(document.getElementById('search-input').value, page);
        };
        pageItem.appendChild(pageLink);
        pagination.appendChild(pageItem);
    }

    if (data.next_page_url) {
        const nextItem = document.createElement('li');
        nextItem.classList.add('page-item');
        const nextLink = document.createElement('a');
        nextLink.classList.add('page-link');
        nextLink.href = '#';
        nextLink.innerText = 'Next';
        nextLink.onclick = (event) => {
            event.preventDefault();
            fetch(document.getElementById('search-input').value, data.current_page + 1);
        };
        nextItem.appendChild(nextLink);
        pagination.appendChild(nextItem);
    } else {
        const nextItem = document.createElement('li');
        nextItem.classList.add('page-item', 'disabled');
        const nextLink = document.createElement('a');
        nextLink.classList.add('page-link');
        nextLink.href = '#';
        nextLink.innerText = 'Next';
        nextItem.appendChild(nextLink);
        pagination.appendChild(nextItem);
    }
}


function rowActions(data){
    const htmlContent = `
    <div class="text-center">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
        
        <label class="btn btn-secondary " >
            <input type="radio" name="options" onclick="${data.viewClick}" id="view-${data.idSuffix}" autocomplete="off" > <i class="bi bi-eye-fill"></i>
        </label>
       
        <label class="btn btn-secondary" >
            <input type="radio" name="options" onclick="${data.editClick}" id="edit-${data.idSuffix}" autocomplete="off"> <i class="bi bi-pencil-square"></i>
        </label>
        <label class="btn btn-secondary" >
            <input id="delete-${data.idSuffix}" onclick="${data.deleteClick}"  type="radio" name="options" autocomplete="off">
           
            <i id="icon-${data.id}" class="bi bi-archive-fill"></i>
            <div id="spinner-${data.id}" class="spinner-grow spinner-grow-sm d-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </label>
        </div>
    </div>
        `;


return htmlContent;
}

function tableNoData(span=4){
    const htmlContent = `
    <tr>
        <td colspan="${span}" class="text-center">No data found</td>
    </tr>
    `;

    return htmlContent;
}

function openUrl(url) {
    window.location.replace(url);
}


async function updateItem(id, updateData, removeApi) {
    try {
        const response = await fetch(removeApi, {
            method: 'post',
            credentials: 'include', 
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updateData)
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }else{
            removeLoader(id, "done")
            location.reload();
        }

        const result = await response.json();

    } catch (error) {
        // Handle any errors that occurred during the fetch
        console.error('Error updating item:', error);
    }
}



async function removeItem(removeApi,id) {
  
    if(confirm("Are you sure you want to remove this item?")) { 
        removeLoader(id, "start")
        const updateData = {
            deleted: true
        };
        await updateItem( id , updateData, removeApi);
    }
   
}


function removeLoader(id, type) {

    const iconElement = document.getElementById(`icon-${id}`);
    const spinnerElement = document.getElementById(`spinner-${id}`);
    console.log(iconElement);

    if(type == "start"){
        iconElement.classList.add('d-none');
        spinnerElement.classList.remove('d-none');
    }else if(type == "done"){
        spinnerElement.classList.add('d-none');
        iconElement.classList.remove('d-none');
    }

   
}



