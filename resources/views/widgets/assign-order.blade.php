<div class="modal fade bs-example-modal-lg" id="assign-order-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="order-id" value=""/>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">{{ $title }}</h4>
            </div>
                <div class="modal-body">
                    <table {!! $attributes !!}>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>联系电话</th>
                            <th>进行中</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{ $row['id'] }}</td>
                                <td>{{ $row['realname'] }}</td>
                                <td>{{ $row['mobile'] }}</td>
                                <td>{{ count($row['accept_orders']) }} 单</td>
                                <td><button class="btn btn-primary btn-xs assign-order" data-openid="{{ $row['openid'] }}">分配</button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>