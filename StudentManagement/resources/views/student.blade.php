
@extends('admin_template')

@section('content')

    <div class="modal fade" id="notification" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Notification</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-details" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit student details</h4>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Name: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Department: </label>
                                </div>
                                <div class="col-md-8">
                                    <select name="department_id">

                                        <!--                            Dung ham lay ra-->
                                        <option value="1">Romaguera PLC</option>
                                        <option value="2">Emmerich, Wilkinson and Collins</option>
                                        <option value="3">O'Conner, Batz and Von</option>
                                        <option value="4">Stanton, Harvey and Jacobson</option>
                                        <option value="5">Jast-Hansen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Email: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Gender: </label>
                                </div>
                                <div class="col-md-8">
                                    <select name="gender">
                                        <option value="0">Female</option>
                                        <option value="1">Male</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Birthday: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" name="birthday">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Address: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Phone: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="phone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-details" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Student</h4>
                </div>
                <form action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id">
                                <p>Are you sure to delete this student?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-student" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add new student</h4>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Name: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Department: </label>
                                </div>
                                <div class="col-md-8">
                                    <select name="department">

                                        <!--                            Dung ham lay ra-->
                                        <option value="1">Romaguera PLC</option>
                                        <option value="2">Emmerich, Wilkinson and Collins</option>
                                        <option value="3">O'Conner, Batz and Von</option>
                                        <option value="4">Stanton, Harvey and Jacobson</option>
                                        <option value="5">Jast-Hansen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Email: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Gender: </label>
                                </div>
                                <div class="col-md-8">
                                    <select name="gender">
                                        <option value="0">Female</option>
                                        <option value="1">Male</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Birthday: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" name="birthday">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Address: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label>Phone: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="phone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row col-md-12">
        <a data-toggle="modal" href="#add-student" class="add-student"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg></a>
        <form class="filter" action="">
            <a href="" class="filter-student"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                </svg> Filter</a>
            <label for="filter-by">By: </label>
            <select id="filter-by">
                <option value=""></option>
                <option value="age-range">Age Range</option>
                <option value="mark-range">Mark Range</option>
                <option value="complete">Complete all subjects</option>
                <option value="in-progress">Still in progess</option>
                <option value="mobile-operator">Mobile operator</option>
            </select>
            <label for="from">From: </label>
            <input type="text" id="from" name="from">
            <label for="to">To: </label>
            <input type="text" id="to" name="to">
            <select>
                <option value="viettel">Viettel</option>
                <option value="vinaphone">Vinaphone</option>
                <option value="mobiphone">Mobiphone</option>
            </select>
            <button type="submit">Submit</button>
        </form>
        <div class="row">
            <div class="col-md-12">
                <table class="table-display table-student">
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>department id</th>
                        <th>email</th>
                        <th>gender</th>
                        <th>birthday</th>
                        <th>address</th>
                        <th>phone</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a data-toggle="modal" href="#edit-details" class="update-details"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg></a>
                            <a data-toggle="modal" href="#delete-details" class="delete-details"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection
