<div class="card flex flex-col" style="height: 200px">
    <h3 class="text-xl py-3 pl-4 -ml-5 mb-3 border-l-4 border-blue-400">
        <a href="{{$project->path()}}" class="text-default no-underline">
            {{$project->title}}
        </a>
    </h3>
    <div class="text-default mb-4 flex-1">
        {{\Illuminate\Support\Str::limit($project->description, 50)}}
    </div>

    @can('manage', $project)
        <footer>
            <form method="post" action="{{$project->path()}}" class="text-right">
                @method('DELETE')
                @csrf
                <button type="submit" class="text-sm hover:underline">
                    Delete
                </button>
            </form>
        </footer>
    @endcan
</div>

