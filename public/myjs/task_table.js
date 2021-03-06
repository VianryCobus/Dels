const createTableTask = (sectionHead,tbody,data,data_user,route,isadmin) => {
    let nofiletask = 1;
    // template or string Literals
    let tHeaders = `<div class="col-lg-12 table-responsive p-3">
                        <p class="h6 my-2 font-weight-bolder">Data File Task</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-info">
                                    <th>No</th>
                                    <th>Name</th>
                                    ${(isadmin == 1) ? `<th>Download</th>` : '<th></th>'}
                                    ${(isadmin != 1) ? `<th>Send Return File</th>
                                                        <th>File Return Name</th>
                                                        <th></th>` : ''}
                                </tr>
                            </thead>
                            <tbody class="tbody-tasktab" id="idtbody">
                            </tbody>
                        </table>
                    <div>`;
    // Insert to DOM
    $(sectionHead).html(tHeaders);

    let tLines = ``;
    $.each(data,(i,e) => {
        // template Literals
        tLines = `<tr>
            <td>${nofiletask}</td>
            <td>${e.task}</td>
            <td>
                <div class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-info btn-download-filetask" id="${e.id}" data-url="${route}/${e.id}/downloadtask">
                        <i class="fas fa-download"></i>
                    </button>
                    ${(isadmin == 1) ? `&nbsp;
                    <button type="button" class="btn btn-danger btn-delete-filetask" id="${e.id}" data-url="${route}/${e.id}/deletetask">
                        <i class="far fa-trash-alt"></i>
                    </button>` : ''}
                </div>
            </td>
            ${(isadmin != 1) ? `<td>
                <div class="d-flex justify-content-center align-items-center form-group">
                    <input type="file" name="return_task[${e.id}]">
                </div>
            </td>
            <td><div class="form-group">${(data_user['return'][e.id]) ? data_user['return'][e.id] : ''}</div></td>
            <td><div class="form-group">
                ${(data_user['id_ttr'][e.id]) ? `<div class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-info btn-download-filereturntask" id="${data_user['id_ttr'][e.id]}" data-url="${route}/${data_user['id_ttr'][e.id]}/downloadreturntask">
                        <i class="fas fa-download"></i>
                    </button>
                </div>` : ''}</div>
            </td>` : ''}
        </tr>`;
        // append to DOM
        $(tbody).append(tLines);
        nofiletask++;
    });
    // $.each(data,function(i,e){
    //     if(isadmin == 1){
    //         $(tbody).append(`
    //             <tr>
    //                 <td>${nofiletask}</td>
    //                 <td>${e.task}</td>
    //                 <td>
    //                     <div class="d-flex justify-content-center align-items-center">
    //                         <button type="button" class="btn btn-info btn-download-filetask" id="${e.id}" data-url="${route}/${e.id}/downloadtask">
    //                             <i class="fas fa-download"></i>
    //                         </button>
    //                         &nbsp;
    //                         <button type="button" class="btn btn-danger btn-delete-filetask" id="${e.id}" data-url="${route}/${e.id}/deletetask">
    //                             <i class="far fa-trash-alt"></i>
    //                         </button>
    //                     </div>
    //                 </td>
    //             </tr>
    //         `);
    //     } else{
    //         let return_task = '';
    //         let return_task_id = '';
    //         if(data_user.id_ttr.length != 0){
    //             return_task = (data_user['return'][e.id]) ? data_user['return'][e.id] : '';
    //             return_task_id = (data_user['id_ttr'][e.id]) ? `<div class="d-flex justify-content-center align-items-center">
    //                 <button type="button" class="btn btn-info btn-download-filereturntask" id="${data_user['id_ttr'][e.id]}" data-url="${route}/${data_user['id_ttr'][e.id]}/downloadreturntask">
    //                     <i class="fas fa-download"></i>
    //                 </button>
    //             </div>` : '';
    //         }
    //         $(tbody).append(`
    //             <tr>
    //                 <td>${nofiletask}</td>
    //                 <td>${e.task}</td>
    //                 <td>
    //                     <div class="d-flex justify-content-center align-items-center">
    //                         <button type="button" class="btn btn-info btn-download-filetask" id="${e.id}" data-url="${route}/${e.id}/downloadtask">
    //                             <i class="fas fa-download"></i>
    //                         </button>
    //                     </div>
    //                 </td>
    //                 <td>
    //                     <div class="d-flex justify-content-center align-items-center form-group">
    //                         <input type="file" name="return_task[${e.id}]">
    //                     </div>
    //                 </td>
    //                 <td><div class="form-group">${return_task}</div></td>
    //                 <td><div class="form-group">${return_task_id}</div></td>
    //             </tr>
    //         `);
    //     }
    //     nofiletask++;
    // });
}

const createOptionTask = (tasks,section) => {
    let options = `
    <div class="col-lg-2">
        <p class="h6 my-2 font-weight-bolder">Tasks List</p>
    </div>
    <div class="col-lg-10 d-flex justify-content-center">
        <select id="optiontasks" class="form-control">
            <option value="">-- Choose the task --</option>
            ${tasks.map(val => `<option value="${val.id}">${val.task}</option>`)}
        </select>
    </div>`;
    const sectionReturnTask = document.querySelector(section);
    sectionReturnTask.innerHTML = options;
}

const createTableReturnTask = (data,section,prefix) => {
    let nofiletask = 1;
    let tHeaders = `<div class="col-lg-12 table-responsive p-3">
                        <p class="h6 my-2 font-weight-bolder">Data File Return Task</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-info">
                                    <th>No</th>
                                    <th>Employee</th>
                                    <th>File Name</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-returntasktab" id="idtbody">
                            </tbody>
                        </table>
                    <div>`;
    const sectionTableReturnTask = document.querySelector(section);
    sectionTableReturnTask.innerHTML = tHeaders;

    let tLines = ``;
    $.each(data,(i,e) => {
        tLines = `<tr>
                    <td>${nofiletask}</td>
                    <td>${e.fname}</td>
                    <td>${e.return_task}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-info btn-download-filereturntask" id="${e.id}" data-url="${prefix}/${e.id}/downloadreturntask">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
        $('.tbody-returntasktab#idtbody').append(tLines);
        nofiletask++;
    });
}