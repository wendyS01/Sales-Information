
#!/bin/bash

# takes 3 parameters, $database $table $columns
database=$1
table=$2
columns=$3

#if too few or many parameters
if ! [ $# -eq 3 ]; then
    echo "Error: parameters problem"
    exit 1
fi

#if the database does not exist
if ! [ -d "$database" ]; then
    echo "Error: DB does not exist"
    exit 1
fi

#critical section, set lock here
./P.sh P.sh
#if the table already exists
if [ -e "$database"/"$table" ]; then
    echo "Error: table already exists"
    #wake up P again
   ./V.sh P.sh
    exit 1
fi

#Everything went well
echo "$columns" > "$database"/"$table"
echo "OK: table created"
#wake up P again
./V.sh P.sh
exit 0