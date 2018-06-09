#!/bin/bash

if [ ! $# -eq 1 ] || [ $1 == "--help" ]
then
echo "to jest pomoc"
echo "jako parametr wejsciowy podaj plik"
else
    if [ ! -f $1 ]
    then
    echo "jako parametr wejsciowy podaj plik"
    else
    cat $1|tr " " "\n"|sort|uniq -c|sort -gr
    fi
fi




