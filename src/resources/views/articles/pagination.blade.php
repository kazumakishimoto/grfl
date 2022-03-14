<div class="paginate">
    {{ $articles->appends(request()->input())->links() }}
</div>
