<?php
namespace MusicApp\Core\Models;

class Pagination {
    const LIMIT = 'limit';
    const PAGE = 'page';
    const TOTAL = 'total';

    public readonly int $page;
    public readonly int $offset;
    public readonly int $nextOffset;
    public readonly int $lastPage;
    public readonly int $total;
    public readonly int $limit;
    public readonly int $count;
    public readonly array $models;

    public function __construct(array $opts, array $models=[]) {
        $this->limit = $opts[Pagination::LIMIT];
        $this->total = $opts[Pagination::TOTAL] ?? -1;
        if ($this->total === -1) {
            $this->page = intval($opts[Pagination::PAGE]);
        } else {
            $this->lastPage = intval(ceil($this->total / $this->limit));
            $this->page = intval(max(1, min($this->lastPage, $opts[Pagination::PAGE])));
        }
        $this->offset = ($this->page - 1) * $this->limit;
        $this->nextOffset = $this->offset + $this->limit;
        $this->count = count($models);
        $this->models = $models;
    }

    protected function str($page=null) : string {
        return http_build_query([
            Pagination::PAGE => $page ?? $this->page,
            Pagination::LIMIT => $this->limit,
        ]);
    }

    public function __toString() : string{
        return $this->str();
    }

    public function to(int $pageNo) : string {
        return $this->str($pageNo);
    }

    public function isLast() : bool {
        return $this->page == $this->lastPage;
    }

    public function next() : string {
        return $this->str($this->page + 1);
    }

    public function prev() : string {
        return $this->str($this->page - 1);
    }
}
?>
