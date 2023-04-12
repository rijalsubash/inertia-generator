# Inertia Generator
<p> The main purpose of this package is to boost development speed bu not repeating developer on basic crud operation. </p>

### dependencies and requirements
    - Docker and Docker compose
    - Node and Npm

### steps to install
    - Clone the repository
    - Create Docker network
    - Run Compoer Install
    - Run Docker compose up 
    - Run npm install 
    - Run npm run dev

## CRUD Generation Guide
Here are the steps that you should follow to generate crud from json file. 

### step 1 -- Prepare json file 

You need to create file in crud directory inside resource path.  
Here is the sample json file: 

File name: Example.json 

```
[
    {
        "column_name": "name",
        "data_type": "string",
        "input_type": "text",
        "rules": "required|in:12,23",
        "label": "Name",
        "searchable": true,
        "in_datatable": true
    },
    {
        "column_name": "birth_date",
        "data_type": "text",
        "input_type": "text",
        "rules": "nullable",
        "label": "Birth Date",
        "in_datatable": true
    },
    {
        "column_name": "radio_group",
        "data_type": "integer",
        "input_type": "radio",
        "rules": "nullable",
        "label": "Radio Example",
        "options": [
            {"value": 1, "label":"opt 1"},
            {"value": 2, "label":"opt 2"}
        ],
        "in_datatable": false
    },
    {
        "column_name": "autocomplete_test",
        "data_type": "integer",
        "input_type": "select",
        "rules": "nullable",
        "label": "Select/Autocomplete Example",
        "options": [
            {"value": 1, "label":"opt 1"},
            {"value": 2, "label":"opt 2"},
            {"value": 3, "label":"opt 3"},
            {"value": 4, "label":"opt 4"},
            {"value": 5, "label":"opt 5"}
        ],
        "in_datatable": false
    }
]

```
You need to specify the column name, label, data type, validation rules for each column form which information, the CRUD will be generated. 

### step 2 -- Run the command

Preety exciting huh :D. 

Lets generate the CRUD with artisan command, 

```
php artisan make:crud ExampleModel --fields=Example.json
```
This command will publish all the files that we need to make a complete CRUD operation based on the file. In future, I am going to add some more features and configuration. For now let's enjoy this much. :) 

### step 3 -- Run migrate
Un-nessary step right? 
Yes, Currently application is in BETA so, I have enabled this extra option to create migration so you can verify yourself as well. 

to do migrate. 

Run 
```
php artisan migrate
```

### step 4 -- All Set. 
Make sure you have run `` npm run dev `` and enjoy the CRUD.  !!!


#### Need help ? 
    subashrijal5@gmail.com



  
