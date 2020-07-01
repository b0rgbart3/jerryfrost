"use strict";


class Work {

    constructor( id, title, created, category, archived, row) {
        this.id = id;
        this.title = title;
        this.created = created;
        this.category = category;
        this.archived = archived;
        this.row = row; // the TR dom element in the list
    }
}