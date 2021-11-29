function createTableEmployee(tbody,data,route){
    $(tbody).empty();
    let nofileemployee = 1;
    $.each(data,function(i,e){
        $(tbody).append(`
            <tr>
                <td>`+nofileemployee+`</td>
                <td>`+e.fname+`</td>
                <td>
                    <input class="form-control" name="pretest[`+e.diuser_id+`]" id="pretest_`+e.diuser_id+`">
                </td>
                <td>
                    <input class="form-control" name="posttest[`+e.diuser_id+`]" id="posttest_`+e.diuser_id+`">
                </td>
                <td>
                    <select class="form-control" name="final_value[`+e.diuser_id+`]" id="finalvalue_`+e.diuser_id+`">
                        <option value="N">Not Graduated</option>
                        <option value="Y">Graduated</option>
                    </select>
                </td>
                <td>
                    <i style="cursor:pointer;" class="fas fa-trash delete-employee" data-url="`+route+`/`+e.diuser_id+`/`+e.training_id+`/deleteemployee"></i>
                </td>
            </tr>
        `);
        let finalvalue = e.final_value ? e.final_value : 'N';
            $("#tbody-employees-table #finalvalue_"+e.diuser_id+" ").val(finalvalue);
        let pretest = e.pretest ? e.pretest : '';
            $("#tbody-employees-table #pretest_"+e.diuser_id+" ").val(pretest);
        let posttest = e.posttest ? e.posttest : '';
            $("#tbody-employees-table #posttest_"+e.diuser_id+" ").val(posttest);
        nofileemployee++;
    });
}