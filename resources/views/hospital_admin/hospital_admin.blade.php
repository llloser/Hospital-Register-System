@extends("master")
@section("title","医院管理")
@section("script")
    <script>
        $(document).ready(function(){
            var office_des_list=$(".office_description");
            $.each(office_des_list,function(i){
                var office_description=$(office_des_list[i]).children().text();
                if(office_description.length>40){
                    var max_office_description=office_description.substr(0,40)+"...";
                    $(office_des_list[i]).children().text(max_office_description);
                }
            })
        })
        function add_office(){
            $("#addFormModal").find(".modal-title").html("添加科室");
            var add_off_form=$('<form></form>').addClass("off_form").attr("id","add_office");
            add_off_form.append(getFormGroup("科室名称","name","text","请输入科室名称"));
            add_off_form.append(getFormGroup("科室描述","description","textarea","请输入科室描述信息"));
            $('#form-content').empty();
            $('#form-content').append(add_off_form);
            var button=$("<button></button>").addClass("btn").addClass("btn-primary").attr("onclick","modal_form_click()").text("提交");
            $("#addFormModal").find(".modal-footer").empty().append(button);
            $('#addFormModal').modal('show');
        }
        function modal_form_click(btn){
            $("#addFormModal").modal('hide');
            //URL需要重新添加
            $("#addFormModal").one('hidden.bs.modal',function(event){    //hidden.bs.modal事件处理函数每次只执行一次
                ajaxOneFormByID('add_office','addOffice',show_result);
            })
        }
        function show_result(data,status){
            if(status!="success"){
                var err_message=$('<div></div>').addClass('alert').addClass('alert-warning').addClass('text-center');
                err_message.html("服务器请求失败");
                showMessage(err_message);
            }
            else{
                var result=JSON.parse(data);
                if(result['status']=='error'){
                    var err_message=$('<div></div>').addClass('alert').addClass('alert-warning').addClass('text-center');
                    err_message.html(result['message']);
                    showMessage(err_message);
                }
                else{
                    var succ_message=$('<div></div>').addClass('alert').addClass('alert-success').addClass('text-center');
                    succ_message.html(result['message']);
                    showMessage(succ_message);
                    show_office(result['office']['id'],result['office']['name'],result['office']['description']);
                }
            }
        }
        function show_office(id,name,description){
            var office_list=$('.one_office');
            for(var i=0;i<office_list.length;i++){
                if(id==$(office_list[i]).find('.office_name').attr('data-id')){
                    $(office_list[i]).find('.office_name').children().text(name);
                    if(description.length>40){
                        var max_description=description.substr(0,40)+"...";
                        $(office_list[i]).find('.office_description').children().text(max_description);
                    }
                    else
                        $(office_list[i]).find('.office_description').children().text(description);
                    $(office_list[i]).find('.office_description').attr("data-info",description);
                    return;
                }
            }
            var off_name=$('<span></span>').text(name);
            var off_des;
            if(description.length>40){
                var max_description=description.substr(0,40)+"...";
                off_des=$('<span></span>').text(max_description);
            }
            else
                off_des=$('<span></span>').text(description);
            var off_panel_head=$('<div></div>').addClass('panel-heading').addClass('office_name').attr('data-id',id).html('科室名称：').append(off_name);
            var off_panel_body=$('<div></div>').addClass('panel-body').addClass('office_description').attr('style','height:5em').html("科室描述：").append(off_des);
            var off_panel=$('<div></div>').addClass('panel').addClass('panel-success').append(off_panel_head).append(off_panel_body);
            var off_button=$('<button></button>').addClass('btn').addClass('btn-primary').attr('onclick','edit_off(this)').text('编辑该科室');
            var off_a=$('<a></a>').addClass('btn').addClass('btn-primary').attr('href','addDoctor?id='+id).text("添加医生");
            var btn1=$('<div></div>').addClass('col-md-6').addClass('text-center').append(off_button);
            var btn2=$('<div></div>').addClass('col-md-6').addClass('text-center').append(off_a);
            var off_main_body=$('<div></div>').addClass('col-md-4').addClass('one_office').append(off_panel).append($('<div></div>').addClass('row').append(btn1).append(btn2)).append('<br/>');
            $("#office_list").append(off_main_body);
        }
        function edit_off(btn){
            $("#addFormModal").find(".modal-title").html("添加科室");
            var off_id=$(btn).parents('.one_office').find('.office_name').attr('data-id');
            var off_name=$(btn).parents('.one_office').find('.office_name').children('span').text();
            var off_description=$(btn).parents('.one_office').find('.office_description').attr("data-info");
            var off_id=$(btn).parents('.one_office').find('.office_name').attr('data-id');
            var add_off_form=$('<form></form>').addClass("off_form").attr("id","add_office").attr('data-id',off_id);
            add_off_form.append(getFormGroupWithValue("科室名称","name","text",off_name));
            add_off_form.append(getFormGroupWithValue("科室描述","description","textarea",off_description));
            add_off_form.append(getFormGroupWithValue(null,'office_id','hidden',off_id));
            showForm(add_off_form);
        }
        function add_triage(){
            $("#addFormModal").find(".modal-title").html("添加分诊台账户");
            var add_triage_form=$('<form></form>').addClass("triage_form").attr("id","add_triage");
            add_triage_form.append(getFormGroup("用户名","name","text","请输入用户名"));
            add_triage_form.append(getFormGroup("邮箱","email","email","请输入邮箱账号"));
            add_triage_form.append(getFormGroup("密码","password","password","请输入密码"));
            $('#form-content').empty();
            $('#form-content').append(add_triage_form);
            var button=$("<button></button>").addClass("btn").addClass("btn-primary").attr("onclick","triage_form_click()").text("提交");
            $("#addFormModal").find(".modal-footer").empty().append(button);
            $('#addFormModal').modal('show');
        }
        function triage_form_click(){
            $("#addFormModal").modal('hide');
            $("#addFormModal").one('hidden.bs.modal',function(event){    //hidden.bs.modal事件处理函数每次只执行一次
                ajaxOneFormByID('add_triage','addTriage',triage_result);
            })
        }
        function triage_result(data,status){
            if(status!="success"){
                var err_message=$('<div></div>').addClass('alert').addClass('alert-warning').addClass('text-center');
                err_message.html("服务器请求失败");
                showMessage(err_message);
            }
            else{
                var result=JSON.parse(data);
                if(result['status']=='error'){
                    var err_message=$('<div></div>').addClass('alert').addClass('alert-warning').addClass('text-center');
                    err_message.html(result['message']);
                    showMessage(err_message);
                }
                else{
                    var succ_message=$('<div></div>').addClass('alert').addClass('alert-success').addClass('text-center');
                    succ_message.html(result['message']);
                    showMessage(succ_message);
                }
            }
        }
    </script>
@stop
@section("extra")
    <div class="row" id="office_list">
        @foreach($offices as $office)
            <div class="col-md-4 one_office">
                <div class="panel panel-success">
                    <div class="panel-heading office_name" data-id="{{$office->id}}">科室名称：<span>{{$office->name}}</span></div>
                    <div class="panel-body office_description" style="height: 5em" data-info="{{$office->description}}">科室描述：<span>{{$office->description}}</span></div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-center"><button class="btn btn-primary" onclick="edit_off(this)">编辑该科室</button></div>
                    <div class="col-md-6 text-center"><a href="addDoctor?id={{$office->id}}" class="btn btn-primary">添加医生</a></div>
                </div>
                <br/>
            </div>
        @endforeach
    </div>
    <div class="row addOff_btn">
        <div class="col-md-8"></div>
        <div class="col-md-2">
            <button class="btn btn-primary btn-lg" onclick="add_triage()">添加分诊台账户</button>
        </div>
        <div class="col-md-2 text-right">
            <button class="btn btn-primary btn-lg" onclick="add_office()">添加一个科室</button>
        </div>
    </div>
@stop