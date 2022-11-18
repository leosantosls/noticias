@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif -->

                    <form method="POST" id="formulario" action="#" onsubmit="return validar()">
                        <input id="id" type="hidden" class="form-control" name="id" value="{{ old('id') }}" required autocomplete="id" autofocus>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="title" class="col-form-label text-md-end">{{ __('Titulo') }}</label>
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                    <span class="invalid-feedback" role="alert">
                                        <strong id="alert"></strong>
                                    </span>
                            </div>

                            <div class="col-md-4">
                                <label for="authot" class="col-form-label text-md-end">{{ __('Autor') }}</label>
                                <input id="authot" type="text" class="form-control @error('authot') is-invalid @enderror" name="authot" value="{{ old('authot') }}" required autocomplete="authot" autofocus>

                                    <span class="invalid-feedback" role="alert">
                                        <strong id="alert"></strong>
                                    </span>
                            </div>

                            <div class="col-md-4">
                                <label for="tags" class="col-form-label text-md-end">{{ __('Tags') }}</label>
                                <input id="tags" type="tags" class="form-control is-valid" name="tags" value="{{ old('tags') }}" required autocomplete="tags" autofocus>

                                <span class="valid-feedback" role="alert">
                                    <strong>Separar as Tags por ( , ). Ex: node, html, php</strong>
                                </span>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="content" class="col-form-label text-md-end">{{ __('Descrição') }}</label>

                                <textarea name="content" id="content"  class="form-control @error('content') is-invalid @enderror" cols="30" rows="3" autocomplete="content" autofocus></textarea>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="alert"></strong>
                                    </span>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" id="btnAcao" class="btn btn-primary">
                                    {{ __('Adicionar') }}
                                </button>
                            </div>
                        </div
                    </form>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ação</th>
                                    <th>Cod</th>
                                    <th>Titulo</th>
                                    <th>Autor</th>
                                    <th>Tags</th>
                                    <th>Descrição</th>
                                </tr>
                            </thead>
                            <tbody id="bodyNoticias">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>

    $(document).ready(function() {
        listsPosts();
    });

    function listsPosts(){
        var url = '/api/auth/posts';

        $.ajax({
            url : url,
            type : 'GET',
            dataType: "json",
            beforeSend : function(xhr){
                if (sessionStorage.getItem("Bearentoken")) {
                    xhr.setRequestHeader("Authorization", "Bearer " +  sessionStorage.getItem("Bearentoken"));
                }
            },
       })
       .done(function(data){

            let tableTd = '';
            for (let index = 0; index < data.length; index++) {
                tableTd += '<tr id="posts-'+data[index].id+'">';
                    tableTd += '<td>'+
                                    '<i onclick="editPosts($(this))"'+
                                    ' data-id="'+data[index].id+'" '+
                                    ' data-title="'+data[index].title+'" '+
                                    ' data-author="'+data[index].author+'" '+
                                    ' data-tags="'+data[index].tags+'" '+
                                    ' data-content="'+data[index].content+'" '+
                                    'class="fa-regular fa-pen-to-square"></i>'+
                                    '  <i onclick="deletePosts('+data[index].id+')" class="fa-solid fa-trash"></i> </td>';
                    tableTd += '<td>'+data[index].id+'</td>';
                    tableTd += '<td>'+data[index].title+'</td>';
                    tableTd += '<td>'+data[index].author+'</td>';
                    tableTd += '<td>'+data[index].tags+'</td>';
                    tableTd += '<td>'+data[index].content+'</td>';
                tableTd += '</tr>';
            }

            $('#bodyNoticias').html(tableTd);
       })
       .fail(function(jqXHR, textStatus, msg){

       });

       return false;

    }

    function editPosts(elem){

       $("#id").val(elem.data('id'));
       $("#title").val(elem.data('title'));
       $("#authot").val(elem.data('author'));
       $("#tags").val(elem.data('tags'));
       $("#content").val(elem.data('content'));

       $("#btnAcao").text('Alterar');

       $("#title").focus();
    }

    function validar(){
        var url = '/api/auth/posts';

        id = $("#id").val();

        tags = $("#tags").val();
        tags = tags.split(",");

        title = $("#title").val();
        authot = $("#authot").val();
        content = $("#content").val();

        data = {};
        data['title'] = title;
        data['authot'] = authot;
        data['content'] = content;
        data['tags'] = tags;

        if(id > 0){
            url = '/api/auth/posts/'+id;

            $.ajax({
                url : url,
                type : 'PUT',
                data : JSON.stringify(data),
                contentType: 'application/json',
                processData: false,
                dataType: "json",
                beforeSend : function(xhr){
                    if (sessionStorage.getItem("Bearentoken")) {
                        xhr.setRequestHeader("Authorization", "Bearer " +  sessionStorage.getItem("Bearentoken"));
                    }
                }
            })
            .done(function(data){
                listsPosts();
                alert('Noticia Editada com sucesso!');
            })
            .fail(function(jqXHR, textStatus, msg){
                    array = jqXHR.responseJSON;

                    Object.keys(array).forEach((item) => {
                        alert(array[item])
                    });
            });
        }else{
            $.ajax({
                url : url,
                type : 'POST',
                data : JSON.stringify(data),
                contentType: 'application/json',
                processData: false,
                dataType: "json",
                beforeSend : function(xhr){
                    if (sessionStorage.getItem("Bearentoken")) {
                        xhr.setRequestHeader("Authorization", "Bearer " +  sessionStorage.getItem("Bearentoken"));
                    }
                }
            })
            .done(function(data){
                let tableTd = '';
                    tableTd += '<tr>';
                        tableTd += '<td>'+
                                        '<i onclick="editPosts($(this))"'+
                                        ' data-id="'+data.id+'" '+
                                        ' data-title="'+data.title+'" '+
                                        ' data-author="'+data.author+'" '+
                                        ' data-tags="'+data.tags+'" '+
                                        ' data-content="'+data.content+'" '+
                                        'class="fa-regular fa-pen-to-square"></i>'+
                                        '  <i onclick="deletePosts('+data.id+')" class="fa-solid fa-trash"></i> </td>';
                        tableTd += '<td>'+data.id+'</td>';
                        tableTd += '<td>'+data.title+'</td>';
                        tableTd += '<td>'+data.author+'</td>';
                        tableTd += '<td>'+data.tags+'</td>';
                        tableTd += '<td>'+data.content+'</td>';
                    tableTd += '</tr>';

                $('#bodyNoticias').append(tableTd);

                alert('Noticia Cadastrada com sucesso!');
            })
            .fail(function(jqXHR, textStatus, msg){
                    array = jqXHR.responseJSON;

                    Object.keys(array).forEach((item) => {
                        alert(array[item])
                    });
            });
        }

        limpar_campos();


       return false;
    }

    function limpar_campos(){
       $("#id").val('');
       $("#title").val('');
       $("#authot").val('');
       $("#tags").val('');
       $("#content").val('');

       $("#btnAcao").text('Adicionar');
    }

    function deletePosts(id){
        var url = '/api/auth/posts/'+id;

        if(confirm("Deseja excluir o registro selecionado?")){
            $.ajax({
                    url : url,
                    type : 'DELETE',
                    beforeSend : function(xhr){
                        if (sessionStorage.getItem("Bearentoken")) {
                            xhr.setRequestHeader("Authorization", "Bearer " +  sessionStorage.getItem("Bearentoken"));
                        }
                    },
            })
            .done(function(data){
                    $("#posts-"+id).remove();
                    alert('Registro Excluido com sucesso!');
            })
            .fail(function(jqXHR, textStatus, msg){

            });
        }
    }

</script>