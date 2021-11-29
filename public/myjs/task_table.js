function createTableTask(sectionHead,tbody,data,data_user,route,isadmin){
    let nofiletask = 1;
    if(isadmin == 1){
        $(sectionHead).html(`
            <div class="col-lg-12 p-3">
                <p class="h6 my-2 font-weight-bolder">Data File Task</p>
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-info">
                            <th>No</th>
                            <th>Name</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-tasktab" id="idtbody">
                    </tbody>
                </table>
            <div>
        `);
    } else{
        $(sectionHead).html(`
            <div class="col-lg-12 p-3">
                <p class="h6 my-2 font-weight-bolder">Data File Task</p>
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-info">
                            <th>No</th>
                            <th>Name</th>
                            <th></th>
                            <th>Send Return File</th>
                            <th>File Return Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="tbody-tasktab" id="idtbody">
                    </tbody>
                </table>
            <div>
        `);
    }
    $.each(data,function(i,e){
        if(isadmin == 1){
            $(tbody).append(`
                <tr>
                    <td>${nofiletask}</td>
                    <td>${e.task}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-info btn-download-filetask" id="${e.id}" data-url="${route}/${e.id}/downloadtask">
                                <i class="fas fa-download"></i>
                            </button>
                            &nbsp;
                            <button type="button" class="btn btn-danger btn-delete-filetask" id="${e.id}" data-url="${route}/${e.id}/deletetask">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        } else{
            let return_task = '';
            let return_task_id = '';
            if(data_user.id_ttr.length != 0){
                return_task = (data_user['return'][e.id]) ? data_user['return'][e.id] : '';
                return_task_id = (data_user['id_ttr'][e.id]) ? `<div class="d-flex justify-content-center align-items-center">
                    <button type="button" class="btn btn-info btn-download-filereturntask" id="${data_user['id_ttr'][e.id]}" data-url="${route}/${data_user['id_ttr'][e.id]}/downloadreturntask">
                        <i class="fas fa-download"></i>
                    </button>
                </div>` : '';
            }
            $(tbody).append(`
                <tr>
                    <td>${nofiletask}</td>
                    <td>${e.task}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-info btn-download-filetask" id="${e.id}" data-url="${route}/${e.id}/downloadtask">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center form-group">
                            <input type="file" name="return_task[${e.id}]">
                        </div>
                    </td>
                    <td><div class="form-group">${return_task}</div></td>
                    <td><div class="form-group">${return_task_id}<div></td>
                </tr>
            `);
        }
        nofiletask++;
    });
}