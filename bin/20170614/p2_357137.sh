#!/bin/bash

if [ ! -f $1 ] || [ $1 == "--help" ] || [ ! $# -eq 1 ]
then
echo "to jest pomoc"
echo "jako parametr wejsciowy podaj plik"
else
cat $1|tr ' ' '\n'|uniq -c|sort -r|cat >> $1
fi




      4 
      2 '
      1 wejsciowy
      1 "to
      1 then
      1 -r|cat
      1 pomoc"
      1 podaj
      1 plik"
      1 parametr
      1 '\n'|uniq
      1 jest
      1 "jako
      1 if
      1 "--help"
      1 fi
      1 -f
      1 -eq
      1 else
      1 echo
      1 echo
      1 -c|sort
      1 cat
      1 #!/bin/bash
      1 $1|tr
      1 $1
      1 $1
      1 $1
      1 1
      1 $#
      1 ]
      1 ]
      1 ]
      1 [
      1 [
      1 [
      1 !
      1 !
      1 ||
      1 ||
      1 >>
      1 ==
      1 
