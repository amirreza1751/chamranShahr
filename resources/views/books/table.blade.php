<div class="table-responsive">
    <table class="table" id="books-table">
        <thead>
            <tr>
                <th>Title</th>
        <th>Edition Id</th>
        <th>Publisher</th>
        <th>Publication Date</th>
        <th>Book Length</th>
        <th>Language Id</th>
        <th>Isbn</th>
        <th>Author</th>
        <th>Translator</th>
        <th>Price</th>
        <th>Size Id</th>
        <th>Is Grayscale</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
            <td>{{ $book->edition_id }}</td>
            <td>{{ $book->publisher }}</td>
            <td>{{ $book->publication_date }}</td>
            <td>{{ $book->book_length }}</td>
            <td>{{ $book->language_id }}</td>
            <td>{{ $book->isbn }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->translator }}</td>
            <td>{{ $book->price }}</td>
            <td>{{ $book->size_id }}</td>
            <td>{{ $book->is_grayscale }}</td>
                <td>
                    {!! Form::open(['route' => ['books.destroy', $book->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('books.show', [$book->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('books.edit', [$book->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
