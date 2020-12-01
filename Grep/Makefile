# Makefile for COMP15 Homework 04 , Summer 2020
# William Huang
# August 6, 2020

CXX=clang++
CXXFLAGS=-std=c++11

default: grep

gerp: word.o interface.o 
	$(CXX) $(CXXFLAGS) word.o interface.o -o gerp
	
word.o: word.cpp word.h
	$(CXX) $(CXXFLAGS) -c word.cpp

interface.o: interface.cpp interface.h index_dir.h word.h
	$(CXX) $(CXXFLAGS) -c interface.cpp

# --- clean destroys all the .o files
clean:
	-@rm -rf *.o 2>/dev/null
