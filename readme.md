FORMAT: 1A

# POLICY-SERVICE

# Policy [/policies]
Policy  resource representation.

## Show all policies [GET /policies]


+ Request (application/json)
    + Body

            {
                "search": {
                    "_id": "string",
                    "title": "string",
                    "slug": "string",
                    "owner": "string"
                },
                "sort": {
                    "newest": "asc|desc",
                    "title": "desc|asc"
                },
                "take": "integer",
                "skip": "integer"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "data": {
                        "_id": "string",
                        "title": "string",
                        "slug": "string",
                        "contents": {
                            "key": "string",
                            "value": "string"
                        },
                        "issued": {
                            "at": "datetime",
                            "by": {
                                "_id": "string",
                                "name": "string"
                            },
                            "to": {
                                "_id": "string",
                                "name": "string"
                            }
                        }
                    },
                    "count": "integer"
                }
            }

## Store Policy [POST /policies]


+ Request (application/json)
    + Body

            {
                "_id": "string",
                "title": "string",
                "slug": "string",
                "contents": {
                    "key": "string",
                    "value": "string"
                },
                "issued": {
                    "at": "datetime",
                    "by": {
                        "_id": "string",
                        "name": "string"
                    },
                    "to": {
                        "_id": "string",
                        "name": "string"
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "_id": "string",
                    "title": "string",
                    "slug": "string",
                    "contents": {
                        "key": "string",
                        "value": "string"
                    },
                    "issued": {
                        "at": "datetime",
                        "by": {
                            "_id": "string",
                            "name": "string"
                        },
                        "to": {
                            "_id": "string",
                            "name": "string"
                        }
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": {
                    "error": [
                        "code must be unique."
                    ]
                }
            }

## Delete Policy [DELETE /policies]


+ Request (application/json)
    + Body

            {
                "id": null
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "_id": "string",
                    "title": "string",
                    "slug": "string",
                    "contents": {
                        "key": "string",
                        "value": "string"
                    },
                    "issued": {
                        "at": "datetime",
                        "by": {
                            "_id": "string",
                            "name": "string"
                        },
                        "to": {
                            "_id": "string",
                            "name": "string"
                        }
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": {
                    "error": [
                        "code must be unique."
                    ]
                }
            }