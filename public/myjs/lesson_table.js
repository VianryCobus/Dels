function createTableLesson(sectionHead,tbody,data,route,isadmin){
    let nofilelesson = 1;
    $(sectionHead).html(`
        <div class="col-lg-12 p-3">
            <p class="h6 my-2 font-weight-bolder">Data File Lesson</p>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr class="table-info">
                        <th>No</th>
                        <th>Name</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody class="tbody-lessontab" id="idtbody">
                </tbody>
            </table>
        <div>
    `);
    $.each(data,function(i,e){
        if(isadmin == 1){
            $(tbody).append(`
                <tr>
                    <td>`+nofilelesson+`</td>
                    <td>`+e.lesson+`</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-info btn-download-filelesson" id="`+e.id+`" data-url="`+route+`/`+e.id+`/downloadlesson">
                                <i class="fas fa-download"></i>
                            </button>
                            &nbsp;
                            <button type="button" class="btn btn-danger btn-delete-filelesson" id="`+e.id+`" data-url="`+route+`/`+e.id+`">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        } else{
            $(tbody).append(`
                <tr>
                    <td>`+nofilelesson+`</td>
                    <td>`+e.lesson+`</td>
                    <td>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-info btn-download-filelesson" id="`+e.id+`" data-url="`+route+`/`+e.id+`/downloadlesson">
                                <i class="fas fa-download"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        }
        nofilelesson++;
    });
}