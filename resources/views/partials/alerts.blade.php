 @if ($errors->any())
     <div class="alert alert-danger">
         <strong>Whoops!</strong> Please fix the following issues:<br><br>
         <ul class="mb-0">
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif
